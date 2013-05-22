<?php


class Un_msm_Paging{
	
	var $link_max_num = UC_MSM_ITEMLIST_MAX;
	var $disp_item_num = UC_MSM_ITEMLIST_MAXITEM;
	var $disp_item_column = UC_MSM_ITEMLIST_COLUM;
	
	
	var $item_slug = UC_MSM_ITEMSLUG;
	var $item_selectID = UC_MSM_ITEMSELECTID;
	var $item_sortID = UC_MSM_ITEMSORTCATE;
	var $item_sortdesc = UC_MSM_ITEMSORTDESC;
	var $item_sortID_array;
	var $item_searchtxt = UC_MSM_ITEMSEARCH;
	
	var $item_searchandor = UC_MSM_ITEMSEARCHANDOR;
	var $item_searchcategory = UC_MSM_ITEMSEARCHCATEGORY;
	var $item_andor_array;
	var $item_searchtarget_array;
	
	var $item_pagingID = UC_MSM_PAGINGID;
	
	
	var $detail_slug = UC_MSM_DETAILSLUG;
	var $detail_selectID = UC_MSM_ITEMDETAILID;
	
	function __construct(){
		$this->item_sortID_array = DefineArray("UC_MSM_ITEMSORT_RARRAY");
		$this->item_andor_array = DefineArray("UC_MSM_ITEMANDOR_RARRAY");
		$this->item_searchtarget_array = DefineArray("UC_MSM_ITEMCATEGORY_RARRAY");
	}
	
	function DispItem($page,$datacount){
		
		$max_page = ceil(intval($datacount)/$this->disp_item_num);
		$return_tag_array["start"] = ($page == 1)? 0: ($page-1)*$this->disp_item_num;
		$return_tag_array["end"] = ($page*$this->disp_item_num);
		
		$return_tag_array["link"] = $this->paging($max_page,$page);
		
		return $return_tag_array;
		
	}
	
	
	
	function paging($limit,$page){
		
		$disp_num = $this->link_max_num;
		$next = $page+1;
		$prev = $page-1;
		
		$index_obj = new UcDsMoshimoPublic;
		$linkarray = $index_obj->GetParmalinkArray();
		
		$slagid = get_page_by_path($this->item_slug)->ID;
		$permalink = get_permalink($slagid);
		
		$first_url_array = $linkarray;
		$limit_url_array = $linkarray;
		$next_url_array = $linkarray;
		$prev_url_array = $linkarray;
		
		$first_url_array[$this->item_pagingID] = 1;
		$firstlink = add_query_arg($first_url_array,$permalink);
		
		$limit_url_array[$this->item_pagingID] = $limit;
		$limitlink = add_query_arg($limit_url_array,$permalink);
		
		$next_url_array[$this->item_pagingID] = $next;
		$nextlink = add_query_arg($next_url_array,$permalink);
		
		$prev_url_array[$this->item_pagingID] = $prev;
		$prevlink = add_query_arg($prev_url_array,$permalink);
	
		$start =  ( $page - floor($disp_num/2) > 0 ) ? ( $page - floor($disp_num/2) ) : 1;
		$end =  ($start > 1) ? ($page+floor($disp_num/2)) : $disp_num;
		$start = ($limit < $end) ? $start-($end-$limit) : $start;
		
		$link_tag = "<div class='uc_pager_area'>";
	   
		if($page != 1 ) {
			$link_tag .= '<a href="'.$prevlink.'" class="uc_prev_link" >&laquo; 前へ</a>';
		}
	   
		if($start >= floor($disp_num/2)){
			$link_tag .= '<a href="'.$firstlink.'" class="uc_first_link" >1</a>';
			if($start> floor($disp_num/2)){
				$link_tag .= "...";
			}
		}
	   
		for($i=$start; $i <= $end ; $i++){								
			$class = ($page == $i) ? ' class="uc_current_link"':' class="uc_normal_link"';
			if($i <= $limit && $i> 0 ){
				
				$temp_url_array = $linkarray;
				$temp_url_array[$this->item_pagingID] = $i;
				$templink = add_query_arg($temp_url_array ,$permalink);
		
				$link_tag .= '<a href="'.$templink.'"'.$class.'>'.$i.'</a>';
			}
		}
	   
		if($limit > $end){
			if($limit-1 > $end ){
				$link_tag .= "...";
			}
			$link_tag .= '<a href="'.$limitlink.'" class="uc_last_link" >'.$limit.'</a>';
		}
		   
		if($page < $limit){
			$link_tag .= '<a href="'.$nextlink.'" class="uc_next_link">次へ &raquo;</a>';
		}
		
		$link_tag .= "</div>";
		
		return $link_tag;
	   
		
	}
}
 


?>