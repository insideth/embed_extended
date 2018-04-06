<?php
/**
 * Embeddable content list item view for file
 * 
 * @uses $vars["entity"] ElggEntity object
 */

$entity = $vars["entity"];

$title = $entity->title;

// don't let it be too long
// Add class "remove" to delete title text on insert
$title = elgg_format_element ('div', ['class' => 'remove'], elgg_get_excerpt($title));

$subtitle = "";
$owner = $entity->getOwnerEntity();
if ($owner) {
	$author_text = elgg_echo("byline", array($owner->name));
	$date = elgg_view_friendly_time($entity->time_created);
	
	$group_text = "";
	$container = $entity->getContainerEntity();
	if (elgg_instanceof($container, "group")) {
		$group_text = elgg_echo("river:ingroup", array($container->name));
	}
	$subtitle = "$author_text $group_text $date";
}

if ($entity->simpletype == "image") {
	$img_attrs = [
		'title' => $title,
		'src' => elgg_get_embed_url ($entity, 'large'),
		'class' => 'embed-insert hidden',
	];
	$title .= elgg_format_element('img', $img_attrs);
} else {
	$title = elgg_view("output/url", array("text" => $title, "href" => $entity->getURL(), "class" => "embed-insert"));
}

$type_subtype_text = "<span class='elgg-quiet'>" . elgg_echo("item:object:file") . "</span>";

$params = array(
	"title" => $title,
	"entity" => $entity,
	"subtitle" => $subtitle,
	"tags" => FALSE,
);
$body = elgg_view("object/elements/summary", $params);

$image = elgg_view_entity_icon($entity, "small");

echo elgg_view_image_block($image, $body, array("image_alt" => $type_subtype_text));
