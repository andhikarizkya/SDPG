<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$tgl_sekarang = date("Ymd");
$tgl_skrg     = date("d");
$bln_sekarang = date("m");
$thn_sekarang = date("Y");
$jam_sekarang = date("H:i:s");

$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
							
function antiinjec($data){
  $filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter_sql;
}
$tgl_full=date("Y-m-d H:i:s");

$sesinf_adminid=1;

function tgl_waktu($data){
	$tgl_waktu=date("d-m-Y H:i:s", strtotime($data));
	return $tgl_waktu;
}

function pagination($query, $per_pg = 10,$pg = 1, $url = '?'){        
	$row = mysql_num_rows(querydb($query));
	$total = $row;
	$adjacents = "2"; 

	$pg = ($pg == 0 ? 1 : $pg);  
	$start = ($pg - 1) * $per_pg;								
	
	$prev = $pg - 1;							
	$next = $pg + 1;
	$lastpg = ceil($total/$per_pg);
	$lpm1 = $lastpg - 1;
	
	$pagination = "";
	if($lastpg > 1)
	{	
		$pagination .= "<ul class='pagination'>";
				//$pagination .= "<li style='float:right; color:green;'>Page $pg of $lastpg</li>";
		if ($lastpg < 7 + ($adjacents * 2))
		{	
			for ($counter = 1; $counter <= $lastpg; $counter++)
			{
				if ($counter == $pg)
					$pagination.= "<li><a class='current'>$counter</a></li>";
				else
					$pagination.= "<li><a href='{$url}pg=$counter'>$counter</a></li>";					
			}
		}
		elseif($lastpg > 5 + ($adjacents * 2))
		{
			if($pg < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $pg)
						$pagination.= "<li><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}pg=$counter'>$counter</a></li>";					
				}
				$pagination.= "<li class='dot'>...</li>";
				$pagination.= "<li><a href='{$url}pg=$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}pg=$lastpg'>$lastpg</a></li>";		
			}
			elseif($lastpg - ($adjacents * 2) > $pg && $pg > ($adjacents * 2))
			{
				$pagination.= "<li><a href='{$url}pg=1'>1</a></li>";
				$pagination.= "<li><a href='{$url}pg=2'>2</a></li>";
				$pagination.= "<li class='dot'>...</li>";
				for ($counter = $pg - $adjacents; $counter <= $pg + $adjacents; $counter++)
				{
					if ($counter == $pg)
						$pagination.= "<li><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}pg=$counter'>$counter</a></li>";					
				}
				$pagination.= "<li class='dot'>..</li>";
				$pagination.= "<li><a href='{$url}pg=$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}pg=$lastpg'>$lastpg</a></li>";		
			}
			else
			{
				$pagination.= "<li><a href='{$url}pg=1'>1</a></li>";
				$pagination.= "<li><a href='{$url}pg=2'>2</a></li>";
				$pagination.= "<li class='dot'>..</li>";
				for ($counter = $lastpg - (2 + ($adjacents * 2)); $counter <= $lastpg; $counter++)
				{
					if ($counter == $pg)
						$pagination.= "<li><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}pg=$counter'>$counter</a></li>";					
				}
			}
		}
		
		if ($pg < $counter - 1){ 
			$pagination.= "<li><a href='{$url}pg=$next'>Next</a></li>";
			$pagination.= "<li><a href='{$url}pg=$lastpg'>Last</a></li>";
		}else{
			$pagination.= "<li><a class='current'>Next</a></li>";
			$pagination.= "<li><a class='current'>Last</a></li>";
		}
		$pagination.= "</ul>\n";		
	}


	return $pagination;
}
?>
