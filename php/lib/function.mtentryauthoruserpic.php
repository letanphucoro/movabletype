<?php
function smarty_function_mtentryauthoruserpic($args, &$ctx) {
    $entry = $ctx->stash('entry');
    if (!$entry) {
        return $ctx->error("No entry available");
    }

    $author = $ctx->mt->db->fetch_author($entry['entry_author_id']);
    if (!$author) return '';

    $asset = $ctx->mt->db->fetch_assets(array('asset_id' => $author['author_userpic_asset_id']));
    if (!$asset) return '';

    $blog =& $ctx->stash('blog');

    require_once("MTUtil.php");
    $asset_url = asset_url($asset[0]['asset_url'], $blog);
    $asset_path = asset_path($asset[0]['asset_file_path'], $blog);
    list($src_w, $src_h, $src_type, $src_attr) = getimagesize($asset_path);
    $dimensions = sprintf('width="%s" height="%s"', $src_w, $src_h);

    $link =sprintf('<img src="%s" %s alt="%s" />',
                   encode_html($asset_url), $dimensions, encode_html($asset['label']));

    return $link;
}
?>
