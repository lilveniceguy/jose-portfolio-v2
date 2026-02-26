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

            $item = [
            'slug'  => $t->slug,
            'label' => $t->name,
            'count' => (int) $t->count,
            'intro' => '',
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

    // Lightweight index of posts (only what panels need)
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

        $post_index[] = [
        'id' => get_the_ID(),
        'title' => get_the_title(),
        'permalink' => get_permalink(),
        'excerpt' => wp_strip_all_tags(get_the_excerpt()),
        'date' => get_the_date('Y-m'),
        'category' => jose_portfolio_primary_category_slug(get_the_ID()), // implement helper
        'tags' => wp_get_post_tags(get_the_ID(), ['fields' => 'slugs']),
        'meta' => [
            // if you store these as post meta (recommended)
            '_company_name' => get_post_meta(get_the_ID(), '_company_name', true),
            '_position_title' => get_post_meta(get_the_ID(), '_position_title', true),
            '_date_start' => get_post_meta(get_the_ID(), '_date_start', true),
            '_date_end' => get_post_meta(get_the_ID(), '_date_end', true),
            '_is_current' => (bool) get_post_meta(get_the_ID(), '_is_current', true),
            '_institution_name' => get_post_meta(get_the_ID(), '_institution_name', true),
            '_degree_title' => get_post_meta(get_the_ID(), '_degree_title', true),
            '_issuing_org' => get_post_meta(get_the_ID(), '_issuing_org', true),
        ],
        ];
    }
    wp_reset_postdata();

    return [
        'skills' => $skills,
        'systems' => $systems,
        'posts' => $post_index,
    ];
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