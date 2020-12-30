<?php
final class Pagination{
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 10;
	public $url = '';
	public $text = 'Toplam {total} kayıttan {start} ile {end} arası gösteriliyor ({pages} Sayfa)'; //"Toplam {pages} sayfa içinde {current_page}. sayfadasınız";
	public $text_first = '|&lt;';
	public $text_last = '&gt;|';
	public $text_next = '&gt;';
	public $text_prev = '&lt;';
	public $style_links = 'links';
	public $style_results = 'results';

	public function render() {	// sayfa numaralandırma fonksiyonu
		$total = $this->total; // 0

		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page; // 1
		}

		if (!$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit; // 20
		}

		$num_links = $this->num_links; // 10
		$num_pages = ceil($total / $limit); // 0/20 = 1

		$output = '';

		if ($page > 1) {
			$output .= ($this->text_first ? ' <a href="' . str_replace('{page}', 1, $this->url) . '">' . $this->text_first . '</a>' : false) . ($this->text_prev ? ' <a  class="prev-button" href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a> ' : false);
    	}

		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages; // 1
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);

				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}

				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			if ($start > 1) {
				$output .= ' .... ';
			}

			for ($i = $start; $i <= $end; $i++) {
				if ($page == $i) {
					$output .= ' <b>' . $i . '</b> ';
				} else {
					$output .= ' <a href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a> ';
				}
			}

			if ($end < $num_pages) {
				$output .= ' .... ';
			}
		}

   		if ($page < $num_pages) {
			$output .= ($this->text_last ? ' <a class="next-button" href="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</a> ' : false) . ($this->text_last ? ' <a href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $this->text_last . '</a> ' : false);
		}

		$find = array(
			'{start}',
			'{end}',
			'{total}',
			'{pages}',
			'{current_page}'
		);

		$replace = array(
			($total) ? (($page - 1) * $limit) + 1 : 0,
			((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit),
			$total,
			$num_pages,
			$page
		);

		return ($output != '' ? '<div id="'.$this->style_links.'" class="' . $this->style_links . '">' . $output . '</div>' : ''); //. '<div class="clear"></div></div>' . '<div class="' . $this->style_results . '">' . str_replace($find, $replace, $this->text) . '</div>' : '');
	}
}
?>
