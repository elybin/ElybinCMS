<?php
/**
 * Generating feed.
 *
 * @package   Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @author		Khakim <elybin.inc@gmail.com>
 */
// RSS
if(whats_opened('rss') || whats_opened('post-rss')){
  if($v = get_feed()){
    header('Content-Type: application/xhtml+xml');
?>
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
  <?php if(!is_single()): ?>
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:wfw="http://wellformedweb.org/CommentAPI/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:atom="http://www.w3.org/2005/Atom"
  xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
  xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
  <?php else: ?>
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
  <?php endif; ?>

  >
  <channel>
    <title><?php e($v->title) ?></title>
    <atom:link href="<?php e($v->atom_link) ?>" rel="self" type="application/rss+xml" />
    <link><?php e($v->link) ?></link>
    <description><?php e(get_option('site_description')) ?></description>
    <lastBuildDate><?php e($v->lastBuildDate) ?></lastBuildDate>
    <language><?php e($v->language) ?></language>
    <sy:updatePeriod><?php e($v->updatePeriod) ?></sy:updatePeriod>
    <sy:updateFrequency><?php e($v->updateFrequency) ?></sy:updateFrequency>
    <generator><?php e($v->generator) ?></generator>
    <image>
      <url><?php e(get_url('favicon')) ?></url>
      <title><?php e(get_option('site_name')) ?></title>
      <link><?php e(get_url('home')) ?></link>
    </image>

    <?php
      // write down the item
      if(count($v->items) > 0 && !is_single()):
        foreach ($v->items as $iv) {
    ?>
    <item>
      <title><?php e($iv->title) ?></title>
      <link><?php e($iv->link) ?></link>
      <comments><?php e($iv->comments) ?></comments>
      <pubDate><?php e($iv->pubDate) ?></pubDate>
      <dc:creator><![CDATA[<?php e($iv->creator) ?>]]></dc:creator>
      <category><![CDATA[<?php e($iv->category) ?>]]></category>
      <guid isPermaLink="false"><?php e($iv->guid) ?></guid>
      <description><![CDATA[<?php e($iv->description) ?>]]></description>
      <content:encoded><![CDATA[<?php e($iv->content_encoded) ?>]]></content:encoded>
      <wfw:commentRss><?php e($iv->commentRss) ?></wfw:commentRss>
      <slash:comments><?php e($iv->comment_count) ?></slash:comments>
    </item>

    <?php
      }
    endif;

    // write down the comments
    if($v->comments && is_single()):
        foreach ($v->comments as $cv) {
    ?>
    <item>
  		<title><?php e($cv->title) ?></title>
  		<link><?php e($cv->link) ?></link>
  		<dc:creator><![CDATA[<?php e($cv->creator) ?>]]></dc:creator>
  		<pubDate><?php e($cv->pubDate) ?></pubDate>
  		<guid isPermaLink="false"><?php e($cv->guid) ?></guid>
  		<description><![CDATA[<?php e($cv->description) ?>]]></description>
  		<content:encoded><![CDATA[<?php e($cv->content_encoded) ?>]]></content:encoded>
  	</item>
    <?php
      }
    endif;
    ?>
  </channel>
</rss>
<?php
  }
}
// ATOM
if(whats_opened('atom') || whats_opened('post-atom')){
  if($v = get_feed()){
    header('Content-Type: application/atom+xml');
?>
<?xml version="1.0" encoding="UTF-8"?>
<feed
  <?php if(is_single()): ?>
  xmlns="http://www.w3.org/2005/Atom"
	xml:lang="<?php e($v->xml_lang) ?>"
	xmlns:thr="http://purl.org/syndication/thread/1.0"
  <?php else: ?>
  xmlns="http://www.w3.org/2005/Atom"
  xmlns:thr="http://purl.org/syndication/thread/1.0"
  xml:lang="<?php e($v->xml_lang) ?>"
  xml:base="<?php e($v->xml_base) ?>"
  <?php endif; ?>
  >
	<title type="text"><?php e($v->title) ?></title>
	<subtitle type="text"><?php e($v->subtitle) ?></subtitle>

	<updated><?php e($v->updated) ?></updated>

	<link rel="alternate" type="text/html" href="<?php e($v->link_alternate) ?>" />
	<id><?php e($v->atom_id) ?></id>
	<link rel="self" type="application/atom+xml" href="<?php e($v->atom_self) ?>" />

	<generator uri="<?php e($v->generator_uri) ?>" version="<?php e($v->generator_version) ?>"><?php e($v->generator_name) ?></generator>

  <?php
    // write down the item
    if(count($v->items) > 0 && !is_single()):
      foreach ($v->items as $iv) {
  ?>
	<entry>
		<author>
			<name><?php e($iv->author) ?></name>
		</author>
		<title type="html"><![CDATA[<?php e($iv->title) ?>]]></title>
		<link rel="alternate" type="text/html" href="<?php e($iv->link_alternate) ?>" />
		<id><?php e($iv->atom_id) ?></id>
		<updated><?php e($iv->updated) ?></updated>
		<published><?php e($iv->published) ?></published>
		<category scheme="<?php e($iv->category_scheme) ?>" term="<?php e($iv->category) ?>" />
    <summary type="html"><![CDATA[<?php e($iv->summary) ?> ]]></summary>
		<content type="html" xml:base="<?php e($iv->link) ?>">
      <![CDATA[<?php e($iv->content_encoded) ?>]]>
    </content>
		<link rel="replies" type="text/html" href="<?php e($iv->comment_uri) ?>" thr:count="1"/>
		<link rel="replies" type="application/atom+xml" href="<?php e($iv->comment_atom_uri) ?>" thr:count="<?php e($iv->comment_count) ?>"/>
		<thr:total><?php e($iv->comment_count) ?></thr:total>
	</entry>

  <?php
      }
    endif;

    // write down the comments
    if($v->comments != false && is_single()):
      foreach ($v->comments as $cv) {
  ?>
	<entry>
		<title type="html"><?php e($cv->title) ?></title>
		<link rel="alternate" type="text/html" href="<?php e($cv->link) ?>" />
		<author>
		    <name><?php e($cv->author) ?></name>
		    <uri><?php e($cv->author_uri) ?></uri>
		</author>
		<id><?php e($cv->atom_id) ?></id>
		<updated><?php e($cv->updated) ?></updated>
		<published><?php e($cv->published) ?></published>
		<content type="html" xml:base="<?php e($cv->link) ?>">
		    <![CDATA[<?php e($cv->content_encoded) ?>]]>
		</content>
		<thr:in-reply-to ref="<?php e($cv->in_reply_to) ?>" href="<?php e($cv->in_reply_to) ?>" type="text/html" />
	</entry>

  <?php
      }
    endif;
  ?>
</feed>
<?php
  }
}
