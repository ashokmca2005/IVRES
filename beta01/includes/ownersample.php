<?php
$dbObj = new DB();
$dbObj->fun_db_connect();

    $page	 = form_int("page",1)+0;
    $sortby  = form_int("sortby",0,0,0);
    $sortdir = form_int("sortdir",0,0,1);
    if (form_isset("reverse")) {
        $sortdir = 1-$sortdir;
    }
    switch($sortdir) {
        case 0 : $orderDir = "ASC"; break;
        case 1 : $orderDir = "DESC"; break;
    }

  // Read search fields from submitted form
    $name = form_text("name");
    $name = stripslashes($name);   

    switch($sortby) {
        case 0: $sortField  = "A.countries_name"; break;
        default: $sortField = "A.countries_name"; break;
    }

/*
$sortField
countries_id
*/

    $sql = "SELECT * FROM ".TABLE_COUNTRIES." AS A ";
    $sql .=" ORDER BY " . $sortField . " " . $orderDir;

	$rs = $dbObj->createRecordset($sql);

//    $rs = $db->createRecordset($sql);

    $search_query = 
					 "name=" . html_escapeURL($name)
					;

	$sort_query   = "sortby=" . html_escapeURL($sortby) .
                    "&sortdir=" . html_escapeURL($sortdir);
    $return_query = $search_query."&".$sort_query."&page=$page";



    // Determine the pagination
	$pag = new Pagination($rs, "&".$search_query."&".$sort_query, 5);
	$pag->current_page = $page;
	$pagination  = $pag->Process();

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td nowrap>Showing <?php echo $pagination['first_row']; ?> - <?php echo $pagination['last_row'];?> of <?php echo $pagination['total_rows']; ?></td>
		<td width="100%" align="right">
		<p style="text-align: right; margin: 0; padding:0;">
			<?php 
			if($pagination['pages']) {
				if($pagination['first']) {
					?>
						<a href="<?php echo $pagination['first']; ?>">&lt; first</a>
						<a href="<?php echo $pagination['prev']; ?>">&lt; prev</a>
					<?php
						} else {
					?>
					&lt; first
					&lt; prev
					<?php
					}
					?>
					|
					<?php
					foreach($pagination['pages'] as $p) {
						if($p['link']){ 
						echo "<a href=\"".$p['link']."\">";
						}
						echo $p['no'];
						if($p['link']){ 
						echo "</a>";
						}
						echo "|";
					}
					if($pagination['last']) {
					?>
						<a href="<?php echo $pagination['next']; ?>">next &gt;</a>
						<a href="<?php echo $pagination['last']; ?>">last &gt;</a>
					<?php
					} else {
					?>
					next &gt;
					last &gt;
				<?php
				}
			}
			?>
		</p>
		</td>
	</tr>
</table>
