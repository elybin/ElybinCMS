<?php
/**
 * Template custom function tags, you can create your own function here.
 *
 * @package Elybin CMS
 * @subpackage YoungFree
 * @since YoungFree 1.2
 */

function youngfree_time_circle(){
  /**
   * Display post time circle.
   * @since YoungFree 1.2
   */
  // custom date
  $date = explode(" ", get_post()->date);
  $date2 = explode("-", $date[0]);
  $monthpfx = date("M", mktime(0,0,0,$date2[1],1,2000));
  echo
   '<div class="circle-date">
    <span class="day-prefix">'.lg('Writed').'</span>
    <span class="day">'.$date2[2].'</span>
    <span class="slash"></span>
    <span class="month">'.$date2[1].'</span>
    <span class="month-prefix">'.$monthpfx.'</span>
    <span class="fa fa-calendar"></span>
   </div>';
 }

function youngfree_entry_meta(){
  /**
   * Display post meta.
   * @since YoungFree 1.2
   */
  printf('
  <i class="fa fa-pencil"></i>&nbsp;%s
  <em><a href="%s">%s</a></em>
  &nbsp;&nbsp;
  <i class="fa fa-comment"></i> %s
  <span class="pull-right">
    %s
    &nbsp;
    <i class="fa fa-clock-o"></i>
  </span>
  ',
  _('Posted by '),
  get_author_posts_url(get_the_author_meta('ID')),
  get_the_author(),
  sprintf('%s %s', get_comments_number(), _n( _('Comment') , _('Comments') , get_comments_number() )),
  get_the_date()
  );
}

function youngfree_thumbnail(){
  /**
   * Display post thumbnails/images.
   * @since YoungFree 1.2
   */
  if(get_post()->image){
    echo '
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 hidden-xs">
      <img src="'.get_post()->image_or.'" class="img-responsive img-rounded" alt="'.get_post()->title.'">
    </div>';
  }
}

function youngfree_more_link(){
  /**
   * Display post thumbnails/images.
   * @since YoungFree 1.2
   */
  if(!is_single()){
  echo '
  <div class="row">
    <div class="col-md-2 pull-right">
      <a href="'.get_post()->detail_url.'" class="btn btn-default pull-right">'.lg('More').'&rarr;</a>
    </div>
    <div class="col-md-10">
      <hr>
    </div>
  </div>
  ';
  }
}
?>
