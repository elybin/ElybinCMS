/*======================= ====================================*/
<?php
include("../../lang/main.php");
?>

/*===== Elybin CMS Javascript Function ========================*/


//ElybinSearch
function ElybinSearch(){
    $("#notfound").hide();
    $('#search').keyup(function(){searchTable()});
    statusCheckUpdate();
}
function searchTable(){
    var inputVal = $("#search").val();
    var table = $("#results");
    var cfound = 0;

    table.find('tr').each(function(index, row)
    {
        var allCells = $(row).find('td');
        if(allCells.length > 0)
        {
            var found = false;
            $("#page-nav").hide();
            allCells.each(function(index, td)
            {
                var regExp = new RegExp(inputVal, 'i');
                if(regExp.test($(td).text()))
                {
                    found = true;
                    cfound++;
                    return false;
                }
            });
            if(found == true)$(row).fadeIn();else $(row).hide();
        }
    });

    //nav fadce
    if($('#search').val() == ""){
        ElybinPager();
        $("#page-nav").fadeIn();
    }

    if(cfound < 1){
         $("#notfound").fadeIn();
         $("#page-nav").hide();
    }else{
        $("#notfound").hide();
    }
}


//ElybinCheckAll
function ElybinCheckAll(){
    $("#tooltip-ck").click(function(){
        checkAll();
        statusCheckUpdate();
    });
}
function checkAll(){
    window.object = "#results thead tr i";
    window.ob_check = "fa fa-check-square";
    window.ob_uncheck = "fa fa-square";
    window.lg_check = "<?php echo $lg_checkall?>";
    window.lg_uncheck = "<?php echo $lg_uncheckall?>";


    if($(window.object).attr("data-original-title") !== window.lg_uncheck){ 
        doCheckAll();
    }else{ 
        doUncheckAll();
    };
    //statusCheckUpdate();
}


function statusCheckUpdate(){
    var banyakdata_all = 0;
    var banyakdata_check = 0;

    
    $(window.object).removeClass(window.ob_check); //remove

    $('input:checkbox:checked').each(function(){
        banyakdata_all = banyakdata_all + 1;
        if($(this).is(":visible")){
            banyakdata_check = banyakdata_check + 1;
        }
    })
    if(banyakdata_check > 0){ 
        statusUncheck(); 
    }else{ 
        statusCheck();
    }
    if(banyakdata_all > 0){
        $("#delall").fadeIn('fast');
    }else{
        $("#delall").hide();
    }
}
function doCheckAll(){
    $("#results :checkbox").each(function(){
       if($(this).is(":visible")){ $(this).prop('checked', true); };
    });
}
function doUncheckAll(){
    $("#results :checkbox").each(function(){
        if($(this).is(":visible")){ $(this).prop('checked', false); }; //false
    });
}
function statusUncheck(){
    $(window.object).attr("data-original-title",window.lg_uncheck); 
    $(window.object).addClass(window.ob_uncheck);
}
function statusCheck(){
    $(window.object).attr("data-original-title",window.lg_check);
    $(window.object).addClass(window.ob_check);
}

//ElybinPager
function ElybinPager(){
    $("#results tbody tr").hide();
	$("#delall").hide();
    var pager = new Pager('results',10); 
	var start = true;
    pager.init(); 
    pager.showPageNav('pager', 'page-nav'); 
    pager.showPage(1);
    window.pager = pager;
    window.start = start;
}
function Pager(tableName, itemsPerPage) {
    this.tableName = tableName;
    this.itemsPerPage = (itemsPerPage);
    this.currentPage = 1;
    this.pages = 0;
    this.inited = false;
    
    this.showRecords = function(from, to) {        
        var rows = document.getElementById(tableName).rows;
        // i starts from 1 to skip table header row

        $("#results tbody tr").fadeOut();
        for (var i = 0; i < (rows.length); i++) {
            if (i < from || i > to) {
                //rows[i].style.display = 'none';
                $("#results tbody tr:eq(" + i + ")").hide();
            }else{
                //rows[i].style.display = '';
                $("#results tbody tr:eq(" + i + ")").stop().fadeIn();
            }
        }
    }
    
    this.showPage = function(pageNumber) {
		// check if not page it self
		if ((this.currentPage == pageNumber) && (window.start == false)) {
			return;
		}
		window.start = false;
		
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}

        var oldPageAnchor = document.getElementById('pg'+this.currentPage);
        oldPageAnchor.className = '';
        
        this.currentPage = pageNumber;
        var newPageAnchor = document.getElementById('pg'+this.currentPage);
        newPageAnchor.className = 'active';
        
        var from = (pageNumber - 1) * itemsPerPage + 0;
        var to = from + itemsPerPage - 1;
        this.showRecords(from, to);

        statusCheckUpdate();
    }   
    
    this.prev = function() {
        if (this.currentPage > 1)
            this.showPage(this.currentPage - 1);
    }
    
    this.next = function() {
        if (this.currentPage < this.pages) {
            this.showPage(this.currentPage + 1);
        }
    }                        
    
    this.init = function() {
        var rows = document.getElementById(tableName).rows;
        var records = (rows.length - 1); 
        this.pages = Math.ceil(records / itemsPerPage);
        this.inited = true;
    }

    this.showPageNav = function(pagerName, positionId) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}
    	var element = document.getElementById(positionId);
    	
    	var pagerHtml = '<li><a onclick="' + pagerName + '.prev();">«</a></li>';
        for (var page = 1; page <= this.pages; page++) 
            pagerHtml += '<li id="pg' + page + '"><a onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</a></li>  ';
        pagerHtml += '<li><a onclick="'+pagerName+'.next();">&#187;</a></li>';            
        
        element.innerHTML = pagerHtml;
    }


}

//countDelData
function countDelData(){
    $("#delall").click(function(){
    DelData();
    return false;
    });

    $(document).ready(function() { 
        $("#delall").hide();
        $("#results :checkbox").click(function() { 
            statusCheckUpdate(); 
        });
    });
}


function DelData(){
    var banyakdata = $('input:checkbox:checked').length;
    var datafix = "";

    var datanama = new Array();
    $('input:checkbox:checked').each(function(){
        var ab = explode("|",$(this).val());
        var cd = "\t<li>" + ab[1] + "</li>\r\n";
        datanama.push(cd);
    }); 
   var datahtml = "<br/><b><i><ol>\r\n";
   for($i = 0; $i < banyakdata; $i++){
        datahtml = datahtml + datanama[$i];
   }
   datahtml = datahtml + "</ol></b></i>";

   $("#deltext").html(datahtml);
   if(banyakdata > 0){
    $("#deleteall").modal('show');
   }
}

function explode(delimiter, string, limit) {
  //  discuss at: http://phpjs.org/functions/explode/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //   example 1: explode(' ', 'Kevin van Zonneveld');
  //   returns 1: {0: 'Kevin', 1: 'van', 2: 'Zonneveld'}

  if (arguments.length < 2 || typeof delimiter === 'undefined' || typeof string === 'undefined') return null;
  if (delimiter === '' || delimiter === false || delimiter === null) return false;
  if (typeof delimiter === 'function' || typeof delimiter === 'object' || typeof string === 'function' || typeof string ===
    'object') {
    return {
      0: ''
    };
  }
  if (delimiter === true) delimiter = '1';

  // Here we go...
  delimiter += '';
  string += '';

  var s = string.split(delimiter);

  if (typeof limit === 'undefined') return s;

  // Support for limit
  if (limit === 0) limit = 1;

  // Positive limit
  if (limit > 0) {
    if (limit >= s.length) return s;
    return s.slice(0, limit - 1)
      .concat([s.slice(limit - 1)
        .join(delimiter)
      ]);
  }

  // Negative limit
  if (-limit >= s.length) return [];

  s.splice(s.length + limit);
  return s;
}
function ElybinView(){
    $(function() {
    $('#view').on('hidden.bs.modal', function () {
         $('#view').removeData('bs.modal');
         $('#view .modal-content').text('<?php echo $lg_loading?>...');
    });
       $("#tooltip a#view-link").click(function(event) {
            event.preventDefault();
            $("#view").modal({remote: $(this).attr("href")});
        })

     })
}
  
function ElybinEditModal(){
    $(function() {
        $("#editmodal-btn").click(function(){
            var title = $('#editmodal-val1').val();
            var content = $('#editmodal-val2').val();
            var category = $('#editmodal-val3').val();
            var author = $('#editmodal-val4').val();
            var status = $('#editmodal-val5').val();
            var act = $('#editmodal-val6').val();
            var mod =  $('#editmodal-val7').val();
            var datastr = 'title=' + title + '&content='+ content + '&category_id='+ category + '&author='+ author + '&status='+ status + '&act='+ act + '&mod='+ mod;
            $.ajax({
                type: "POST",
                url: "app/post/proses.php",
                data: datastr,
                cache: false,
                success: function(html){
                    var url = "?mod=post&act=editquick&clear=yes&id=" + html;
                    $("#editmodal").modal({remote: url});
                    $("#post-count-panel").text(Number($("#post-count-panel").text()) + 1);
                    $('#editmodal-val1').val("");
                    $('#editmodal-val2').val("");
                }
            });
            return false;
        });


        $('#editmodal').on('hidden.bs.modal', function () {
             $('#editmodal').removeData('bs.modal');
             $('#editmodal .modal-content').text('<?php echo $lg_loading?>...');
        });

     })
}

function ElybinLocationPicker(CurrentLat, CurrentLong, actionUrl){
  $('#google-maps').locationpicker({
  location: {latitude: CurrentLat, longitude: CurrentLong}, 
  radius: 300,
  inputBinding: {
    locationNameInput: $('#address')        
  },
  enableAutocomplete: true,
  onchanged: function(currentLocation, radius, isMarkerDropped) {
    $("#coordinate span").html(currentLocation.latitude + ", " + currentLocation.longitude);
    $("#btn-save").removeClass("btn-disabled").addClass("btn-success").html('<i class="fa fa-check"></i>&nbsp;Save Location');
  } 
  });
  $("#btn-save").click(function(){
    $(this).removeClass("btn-success").addClass("btn-disabled").html('<i class="fa fa-spinner"></i>&nbsp;Saving...').prop('disabled', true);
    var value = $('#coordinate span').text();
    var pk = 'option';
    var name =  'site_coordinate';
    var dataString = 'value='+ value + '&pk='+ pk + '&name='+ name;
    $.ajax({
      type: "POST",
      url: actionUrl,
      data: dataString,
      cache: false,
      success: function(data) {
        data = explode(",",data);

        if(data[0] == "ok"){
          $("#btn-save").removeClass("btn-disabled").addClass("btn-success").html('<i class="fa fa-check"></i>&nbsp;Saved!').prop('disabled', false);
          window.history.back();
          $.growl.notice({ title: data[1], message: data[2] });
          window.location.href="?mod=option";
        }
      }
    });
    return false;
  });
}

//
function ElybinHideShow(TriggerId, TargetId){
  var $tid = $("#"+TriggerId);
  var $taid = $("#"+TargetId);
  var $hibtn = $("#"+TargetId+" #close");

  $hibtn.hide();
  $tid.click(function(){
    $("#close").not("#"+TargetId).click();

    $(this).hide();
    $taid.slideDown();
    $hibtn.fadeIn();
    return false;
  });
  $hibtn.click(function(){
    $tid.show();
    $taid.slideUp();
    $hibtn.hide();
  })
}

// function upload images to media
function uploadMedia(file, editor, editable){
  $('#summernote-progress').fadeIn();

  data = new FormData();
  data.append("mod", "media");
  data.append("act", "add");
  data.append("callback", "url");
  data.append("file", file);
  $.ajax({
    url: 'app/media/proses.php',
    xhr: function() {
      var myXhr = $.ajaxSettings.xhr();
      if (myXhr.upload) myXhr.upload.addEventListener('progress',progressHandlingFunction, false);
      return myXhr;
    },
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    success: function(data){
      editor.insertImage(editable, data);
    }
  })
}

// update progress bar
function progressHandlingFunction(e){
    if(e.lengthComputable){
        $('#summernote-progress .progress-bar').css({"width":(e.loaded/e.total)*100 + '%'});
        $('#summernote-progress p span').html(Math.round((e.loaded/e.total)*100) + '%');
        // reset progress on complete
        if (e.loaded == e.total) {
            $('#summernote-progress').fadeOut(function(){
              $('#summernote-progress .progress-bar').css({"width":"0%"});
              $('#summernote-progress p span').html('0%');
            });
            
        }
    }
}
