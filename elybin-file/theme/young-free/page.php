<?php
  // pages
  $id = @$_GET['id'];
  $tbp = new ElybinTable('elybin_pages');

  $pagestat = $tbp->GetRowAnd('page_id',$id,'status','active');
  if($pagestat == 0){
    header('location: 404.html');
    exit;
  }

  $page = $tbp->SelectWhereAnd('page_id',$id,'status','active','','')->current();
  // meta
  $subtitle = $page->title;
  $meta_desc = substr(strip_tags(html_entity_decode($page->content)),0,200);
  $meta_keyword = keyword_filter(strip_tags(html_entity_decode($page->content)));

  $content = $page->content;
  $content = html_entity_decode($content);


  include_once 'header.php';
  include_once 'menu.php';
?>
    <!-- Main Content -->
    <div class="container">
		<!-- margin -->
		<div class="clearfix" style="margin-top:90px"></div>
        <!-- search bar -->
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <?php echo $content?>
            </div>

        </div>
        <!-- .row -->
    </div>
<?php
  include "footer.php";
?>
