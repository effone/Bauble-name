<?php
/**
 * ACP Language file for MyBB Plugin : "Optimised First / Last Post Avatar"
 * Author: effone (https://eff.one)
 * 
 * Website: https://github.com/mybbgroup/flap
 *
 */

$l['flap_name'] = 'Optimised First / Last Post Avatar';
$l['flap_desc'] = 'A plugin that allows optimized first and last post avatar around the forum.';

$l['setting_group_flap_desc'] = 'Various settings for Optimised First / Last Post Avatar.';

$l['setting_flap_crop'] = 'Crop Avatar?';
$l['setting_flap_crop_desc'] = 'Crop the avatar image to match the defined size while compressing / resizing?';

$l['setting_flap_avatarsize'] = 'Avatar Dimension';
$l['setting_flap_avatarsize_desc'] = 'Dimension of the avatars to be scaled down in. Width and height to be separated with "|", for example \'50|50\'.<br /><i>Note:</i> Wrong input or pattern will default the value to \'44|44\'';

$l['setting_flap_strictsize'] = 'Avatar Dimension Strict Mode';
$l['setting_flap_strictsize_desc'] = 'Strictly adhere above-defined avatar dimension regardless of original avatar aspect ratio.<br /><i>Note:</i> If the defined dimension is greater than maximum allowed dimension, the lower will be considered.';

$l['setting_flap_quality'] = 'Compression Quality';
$l['setting_flap_quality_desc'] = 'Quality of the compressed image.';

$l['setting_flap_avail'] = 'Availability';
$l['setting_flap_avail_desc'] = 'Make the avatars available in the following areas.<br /><i>Scope:</i> ¹ First Avatar only, ² Last Avatar Only, ³ First & Last Avatar';

$l['flap_quality_asis'] = 'As Is (No Compression)';
$l['flap_quality_default'] = 'Optimal (Default zlib)';
$l['flap_quality_good'] = 'Good (Higher size)';
$l['flap_quality_medium'] = 'Medium';
$l['flap_quality_lossy'] = 'Lossy (Lower size)';

$l['setting_flap_cdnlink'] = 'CDN Link';
$l['setting_flap_cdnlink_desc'] = 'If you are using a CDN or remote asset mirror service provide the link. This will be used to fetch avatars from instead of local asset_url, if set.<br />(Trailing \'/\' doens\'t matter.)';