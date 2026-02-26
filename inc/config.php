<?php
function jose_portfolio_build_ui_payload(): array {
    // Skills = post tags (or change to a dedicated taxonomy later)
    $tags = get_terms([
        'taxonomy' => 'post_tag',
        'hide_empty' => true,
    ]);

    $skills = [];
    $systems = [];

    $system_slugs = array_flip(jose_portfolio_system_tag_slugs());

    if (is_array($tags)) {
        foreach ($tags as $t) {
            $term = get_term($t->term_id, 'post_tag');
            $intro = ($term && !is_wp_error($term) && !empty($term->description)) ? $term->description : '';

            $item = [
                'slug'  => $t->slug,
                'label' => $t->name,
                'count' => (int) $t->count,
                'intro' => $intro,
            ];

            if (isset($system_slugs[$t->slug])) {
            $systems[] = $item;
            } else {
            $skills[] = $item;
            }
        }
    }

    // Optional: sort by usage count descending
    usort($skills, function($a, $b) {
        return $b['count'] <=> $a['count'];
    });

    usort($systems, function($a, $b) {
        return $b['count'] <=> $a['count'];
        });

    // Lightweight index of posts (only what panels need). Align with experience.php meta (jp_*).
    $post_index = [];
    $q = new WP_Query([
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 200, // safe cap, adjust later
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
    ]);

    while ($q->have_posts()) {
        $q->the_post();
        $post_id = get_the_ID();

        $tags_raw = get_the_tags($post_id) ?: [];
        $tag_slugs = wp_list_pluck($tags_raw, 'slug');
        $tag_names = wp_list_pluck($tags_raw, 'name');

        // Work experience meta (same as experience.php)
        $jp_position = get_post_meta($post_id, 'jp_position_title', true);
        $jp_location = get_post_meta($post_id, 'jp_location', true);
        $jp_emp_type = get_post_meta($post_id, 'jp_employment_type', true);
        $jp_start = get_post_meta($post_id, 'jp_date_start', true);
        $jp_end = get_post_meta($post_id, 'jp_date_end', true);
        $jp_current = (bool) get_post_meta($post_id, 'jp_is_current', true);

        $date_label = '';
        if ($jp_start) {
            $fmt = function ($ymd) {
                if (!$ymd) return '';
                $t = strtotime($ymd);
                return $t ? date('Y-m', $t) : '';
            };
            $date_label = $fmt($jp_start) . ' - ' . ($jp_current ? 'Present' : $fmt($jp_end));
        }

        $emp_label = '';
        if ($jp_emp_type === 'remote') $emp_label = 'Remote';
        elseif ($jp_emp_type === 'hybrid') $emp_label = 'Hybrid';
        elseif ($jp_emp_type === 'onsite') $emp_label = 'Onsite';

        $location_label = trim(implode(', ', array_filter([$jp_location, $emp_label])));

        $post_index[] = [
            'id' => $post_id,
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'excerpt' => wp_strip_all_tags(get_the_excerpt()),
            'date' => get_the_date('Y-m'),
            'category' => jose_portfolio_primary_category_slug($post_id),
            'tags' => $tag_slugs,
            'tag_names' => array_values($tag_names),
            'meta' => [
                '_company_name' => get_post_meta($post_id, '_company_name', true),
                '_position_title' => get_post_meta($post_id, '_position_title', true),
                '_date_start' => get_post_meta($post_id, '_date_start', true),
                '_date_end' => get_post_meta($post_id, '_date_end', true),
                '_is_current' => (bool) get_post_meta($post_id, '_is_current', true),
                '_institution_name' => get_post_meta($post_id, '_institution_name', true),
                '_degree_title' => get_post_meta($post_id, '_degree_title', true),
                '_issuing_org' => get_post_meta($post_id, '_issuing_org', true),
                // jp_* (work experience, used by experience.php and sidebar)
                'jp_position_title' => $jp_position,
                'jp_location' => $jp_location,
                'jp_employment_type' => $jp_emp_type,
                'jp_date_start' => $jp_start,
                'jp_date_end' => $jp_end,
                'jp_is_current' => $jp_current,
                'date_label' => $date_label,
                'location_label' => $location_label,
            ],
            'bullets' => jose_portfolio_post_bullets($post_id),
        ];
    }
    wp_reset_postdata();

    return [
        'skills' => $skills,
        'systems' => $systems,
        'posts' => $post_index,
    ];
}

/**
 * Extract bullet-point strings from post content (list blocks or HTML list items).
 * Used by the skill sidebar to show key responsibilities.
 */
function jose_portfolio_post_bullets(int $post_id): array {
    $raw = get_post_field('post_content', $post_id);
    if (!$raw) return [];

    $bullets = [];
    if (function_exists('parse_blocks')) {
        $blocks = parse_blocks($raw);
        foreach ($blocks as $block) {
            if (!is_array($block) || (isset($block['blockName']) && $block['blockName'] === 'jose-portfolio/job-detail')) {
                continue;
            }
            if (isset($block['blockName']) && $block['blockName'] === 'core/list') {
                if (!empty($block['innerContent'])) {
                    foreach ($block['innerContent'] as $html) {
                        if (is_string($html) && preg_match_all('/<li[^>]*>(.*?)<\/li>/s', $html, $m)) {
                            foreach ($m[1] as $li) $bullets[] = wp_strip_all_tags($li);
                        }
                    }
                }
                if (!empty($block['innerBlocks'])) {
                    foreach ($block['innerBlocks'] as $inner) {
                        if (isset($inner['innerContent'][0])) {
                            $bullets[] = wp_strip_all_tags($inner['innerContent'][0]);
                        }
                    }
                }
            }
        }
    }
    if (empty($bullets) && preg_match_all('/<li[^>]*>(.*?)<\/li>/s', $raw, $m)) {
        foreach ($m[1] as $li) $bullets[] = wp_strip_all_tags($li);
    }
    return array_slice(array_filter(array_map('trim', $bullets)), 0, 10);
}

function jose_portfolio_primary_category_slug(int $post_id): string {
    $cats = get_the_category($post_id);
    if (!$cats) return '';
    // pick first, or implement "primary" logic later
    return $cats[0]->slug ?? '';
}

function jose_portfolio_system_tag_slugs(): array {
    return [

        // Cloud / Infrastructure
        'aws',
        'ec2',
        'ecs',
        's3',
        'route53',
        'iam',
        'cloudflare',
        'devops',
        'deploy',
        'server',
        'cron-jobs',
        'scripts',
        'shell',

        // Operating Systems / Server Stack
        'linux',
        'centos',
        'debiant',
        'redhat',
        'rhel',
        'windows-server',
        'iis',
        'windows-active-directory',
        'lamp',
        'smtp-server',
        'mail',

        // Databases / Data Platforms
        'oracle',
        'postgresql',
        'mysql',
        'big-data',
        'datalake',
        'hadoop',
        'hive',
        'hue',
        'oozie',
        'cloudera',
        'pyspark',

        // BI / Analytics Platforms
        'powerbi',
        'tableau',
        'excel',
        'powerpoint',
        'jupiter-notebook',

        // Business / E-commerce Platforms
        'odoo',
        'odoo-api',
        'shopify',
        'opencart',
        'prestashop',
        'joomla',
        'mercado-pago',
        'transbank',
        'payment',
        'enviame',

        // SaaS / Integrations
        'recurly',
        'braze',
        'osano',

        // Enterprise / Ops Systems
        'whs',
        'icqa',
        'pick',
        'pack',
        'sort',
        'shipping',
        'printers',
        'ris',
        'gis',
        'dicom',
    ];
}