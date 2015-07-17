<?php
	//This creates a friendly URL
	function create_furl($title){
		$title = trim($title);
		$title = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $title);
		$title = preg_replace('/\s+/', ' ',$title);
		$title = str_replace(' ', '-', $title);
		return $title;
	}
	
	//This generates a random string of alphanumerics which is used as the unique ID at the database tables
	function generateId(){
		$length = 10;
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-";
		$str = '';
		
		$size = strlen($chars);
		for($i = 0; $i < $length; $i++)
		{
			if($i == 0 || $i == $length - 1)
			{
				do{
					$char = $chars[ mt_rand( 0, $size - 1 ) ];
				}while($char == "-");
				$str .= $char;
			}else{
				$str .= $chars[ mt_rand( 0, $size - 1 ) ];
			}
		}
		return $str;
	}
	
	//Swaping values in a single variable
	function swap($main_variable, $value1, $value2)
	{
		if ($main_variable == $value1)
		{
			$main_variable = $value2;
		}else{
			$main_variable = $value1;
		}
		return $main_variable;
	}
	
	//Function for menu and submenu generation
	function print_children($pcid, $pcs, $mi_mother = '0', $mi_disabled = "", $current_mi = '0')
	{	
		global $DLTL;
		
		$sql_p_c = "SELECT * FROM `menu_items` 
					INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID=`menu_items-languages`.MI_ID
					WHERE `menu_items`.MI_DELETED = 0 AND `menu_items`.MI_MOTHER = '$pcid' 
					AND `menu_items-languages`.L_ID = '$DLTL'  
					ORDER BY `menu_items`.MI_RANK, `menu_items-languages`.MIL_ALIAS";
		$query_p_c = mysql_query($sql_p_c);
		$rows_p_c = mysql_num_rows($query_p_c);
		if ($rows_p_c)
		{
			while($result_p_c = mysql_fetch_array($query_p_c))
			{
				$mi_selected = "";
				if($result_p_c['MI_ID']== $mi_mother){
					$mi_selected = "SELECTED";
				}
				
				$i_am_current = false;
				if($current_mi == $result_p_c['MI_ID'])
				{
					$mi_disabled = "DISABLED";
					$i_am_current = true;
				}
				
				echo '<option value="'.$result_p_c['MI_ID'].'" '.$mi_selected.' '.$mi_disabled.'>'.$pcs.stripslashes($result_p_c['MIL_ALIAS']).'</option>';
				print_children($result_p_c['MI_ID'],$pcs.' - - - ', $mi_mother, $mi_disabled, $current_mi);
				if($i_am_current)
					$mi_disabled = "";
			}
			
		}
	}

	//prints menu stracture
	function print_structure($pcid, $ident, $mi_mother = '0'){	
		global $TOOLBAR_LANG;
		$sql_p_c = "SELECT * FROM `menu_items` 
					INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID=`menu_items-languages`.MI_ID
					WHERE `menu_items`.MI_DELETED=0 AND `menu_items`.MI_MOTHER='$pcid' 
					AND `menu_items-languages`.L_ID = '$TOOLBAR_LANG' 
					ORDER BY `menu_items`.MI_RANK, `menu_items-languages`.MIL_ALIAS";
		$query_p_c = mysql_query($sql_p_c);
		$rows_p_c = mysql_num_rows($query_p_c);
		if ($rows_p_c){
			while($result_p_c = mysql_fetch_array($query_p_c)){
				$link = '<a href="?action=menu_items_edit&id='.$result_p_c['MI_ID'].'&tl='.$TOOLBAR_LANG.'">'.stripslashes($result_p_c['MIL_ALIAS']).'</a>';
				echo '<li>'.$ident.$link.'</li>';
				print_structure($result_p_c['MI_ID'],$ident.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ', $mi_mother);
			}
		}
	}
	
	//prints menu stracture for articles
	function print_structure_article($pcid, $pcs, $mi_mother = '0')
	{	
		global $tab_lang;
		global $DLTL;
		
		$sql_p_c = "SELECT *, `menu_items`.MI_ID AS MIID FROM `menu_items` 
					INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID=`menu_items-languages`.MI_ID
					WHERE `menu_items`.MI_DELETED=0 AND `menu_items`.MI_MOTHER = '$pcid' 
					AND `menu_items-languages`.L_ID = '$DLTL' 
					ORDER BY `menu_items`.MI_RANK, `menu_items-languages`.MIL_ALIAS";
		$query_p_c = mysql_query($sql_p_c);
		$rows_p_c = mysql_num_rows($query_p_c);
		if ($rows_p_c)
		{
			while($result_p_c = mysql_fetch_array($query_p_c))
			{
				$is_disabled = "";
				if($result_p_c['MT_ID'] != '8BPTpENdPB'){
					$is_disabled = "DISABLED";
				}
				$mi_selected = "";
				if($result_p_c['MIID'] == $mi_mother){
					$mi_selected = "SELECTED";
				}
				echo '<option value="'.$result_p_c['MI_ID'].'" '.$mi_selected.' '.$is_disabled.'>'.$pcs.stripslashes($result_p_c['MIL_ALIAS']).'</option>';
				print_structure_article($result_p_c['MI_ID'],$pcs.' - - - ', $mi_mother);
			}
		}
	}
	
	//prints menu stracture for galleries
	function print_structure_gallery($pcid, $pcs, $mi_mother = '0')
	{	
		global $tab_lang;
		global $DLTL;
		
		$sql_p_c = "SELECT * FROM `menu_items` 
					INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID=`menu_items-languages`.MI_ID
					WHERE `menu_items`.MI_DELETED = 0 AND `menu_items`.MI_MOTHER = '$pcid'  
					AND `menu_items-languages`.L_ID = '$DLTL'   
					ORDER BY `menu_items`.MI_RANK, `menu_items-languages`.MIL_ALIAS";
		$query_p_c = mysql_query($sql_p_c);
		$rows_p_c = mysql_num_rows($query_p_c);
		if ($rows_p_c)
		{
			while($result_p_c = mysql_fetch_array($query_p_c))
			{
				$is_disabled = "";
				if($result_p_c['MT_ID'] != 'EKatjWfxOt'){
					$is_disabled = "DISABLED";
				}
				$mi_selected = "";
				if($result_p_c['MI_ID'] == $mi_mother){
					$mi_selected = "SELECTED";
				}
				echo '<option value="'.$result_p_c['MI_ID'].'" '.$mi_selected.' '.$is_disabled.'>'.$pcs.stripslashes($result_p_c['MIL_ALIAS']).'</option>';
				print_structure_gallery($result_p_c['MI_ID'],$pcs.' - - - ', $mi_mother);
			}
		}
	}
	
	//prints menu stracture for menu listing
	function print_menu_row($id, $mother, $TOOLBAR_LANG){
		global $TOOLBOX_SELECTED_OPTIONS;
		global $mysql_order_by;
		
		$sql_m_r = "SELECT * FROM `menu_items` 
				   INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID=`menu_items-languages`.MI_ID 
			       INNER JOIN `menu_groups-menu_items` ON `menu_items`.MI_ID=`menu_groups-menu_items`.MI_ID 
			       INNER JOIN `menu_groups-languages` ON `menu_groups-languages`.MG_ID=`menu_groups-menu_items`.MG_ID 
				   WHERE `menu_items-languages`.L_ID = '$TOOLBAR_LANG' 
				   AND `menu_groups-languages`.L_ID =  '$TOOLBAR_LANG' 
			       AND `menu_items`.MI_DELETED = 0
				   AND `menu_items`.MI_MOTHER = '$id' 
			       ORDER BY `menu_groups-languages`.MGL_ALIAS, $mysql_order_by ";
		$query_m_r = mysql_query($sql_m_r);
		$rows_m_r = mysql_num_rows($query_m_r);
		if ($rows_m_r){
			while($result_m_r = mysql_fetch_array($query_m_r)){
				//START:Create the links
				$edit_link = '?action=menu_items_edit&id='.$result_m_r['MI_ID'].$TOOLBOX_SELECTED_OPTIONS;
				$delete_link = '<a href="scripts/menu_groups_delete.php?id='.$result_m_r['MI_ID'].$TOOLBOX_SELECTED_OPTIONS.'" onclick="return checkfields(this);" class = "delete"><img src="images/delete.png" title="Διαγραφή" /></a>';
				$isDefault = '<a href = "scripts/menu_items_default.php?id='.$result_m_r['MI_ID'].$TOOLBOX_SELECTED_OPTIONS.'" class = "star" title = "Αλλαγή σε προεπιλεγμένο"><img src = "images/isDefaultGrey.png" /></a>';
				if ($result_m_r['MI_DEFAULT']){
					$isDefault = '<a href = "javascript:;" class = "star no-link"><img src = "images/isDefaultGold.png" title = "Προεπιλεγμένο" /></a>';
				}
				//END:Create the links
				
				//START:Echo visibility
				$visibility_caption = "Όχι";
				if ($result_m_r['MI_VISIBLE']) 
					$visibility_caption = "Ναι";
				//END:Echo visibility
				
				echo '<li class = "hasDefault">
						'.$isDefault.'
						<a href = "'.$edit_link.'" title = "Επεξεργασία">'.stripslashes($result_m_r['MIL_ALIAS']).'</a>
						<span class = "details">'.$mother.stripslashes($result_m_r['MIL_ALIAS']).'</span>
						<span class = "details">Ομάδα Μενού: '.stripslashes($result_m_r['MGL_ALIAS']).', Κατάταξη: '.$result_m_r['MI_RANK'].', Ορατό: '.$visibility_caption.'</span>
						'.$delete_link.'
					</li>';
				
				//START:Define mothers name/title
				$mi_mother = $mother.$result_m_r['MIL_ALIAS'].' &raquo; ';
				//END:Define mothers name/title
				
				print_menu_row($result_m_r['MI_ID'], $mi_mother, $TOOLBAR_LANG);
			}
			
		}
	}
	
	//Electro log entries
	function eLog($action)
	{
		global $valid_entry;
		global $commit;
		
		$elog_date = date("Y-m-d H:i:s");
		$elog_user = $_SESSION['EU_ID'];
		
		//START: Generate ID
		do{
			$generatedId = generateId();
			$sql_id = "SELECT * FROM `electro_log` WHERE ELOG_ID='".$generatedId."'";
			$query_id = mysql_query($sql_id);
			$rows = mysql_num_rows($query_id);
		}while($rows);
		//END: Generate ID
		
		$sql_elog = "INSERT INTO `electro_log` VALUES ('$generatedId','$elog_date','$elog_user','$action')";
		$query_elog = mysql_query($sql_elog);
		if (!$query_elog)
		{
			$valid_entry = 0;
			$commit = "rollback";
		}
	}
?>