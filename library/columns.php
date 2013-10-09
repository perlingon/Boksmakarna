<?php
/**
 * get_columns_array
 *
 * Columns for the loop, single function interface (limited) 
 *
 * Copyright (c) 2011 hakre <http://hakre.wordpress.com/>, some rights reserved
 *
 * USAGE:
 *
 *   foreach(get_columns_array($post_count) as $column_count) :
 *     // column starts here
 *     while ($column_count--) : $the_query->the_post();
 *         // output your post
 *     endwhile;
 *     // column ends here
 *   endforeach;
 * 
 * @author hakre <http://hakre.wordpress.com/>
 * @see http://wordpress.stackexchange.com/q/9308/178
 */
function get_columns_array($totalCount, $columnSize) {
	$columns = array();
	$totalCount = (int) max(0, $totalCount);
	if (!$count)
		return $columns;	
	$columnSize = (int) max(0, $columnSize);
	if (!$columnSize)
		return $columns;
	($floor = (int) ($totalCount / $columnSize))
                && $columns = array_fill(0, $floor, $columnSize)
                ;
	($remainder = $totalCount % $columnSize)
		&& $columns[] = $remainder
		;
	return $columns;
}
 
/**
 * WP_Query_Columns
 *
 * Columns for the loop. 
 *
 * Copyright (c) 2011 hakre <http://hakre.wordpress.com/>, some rights reserved 
 * 
 * @author hakre <http://hakre.wordpress.com/>
 * @see http://wordpress.stackexchange.com/q/9308/178
 */
class WP_Query_Columns implements Countable, IteratorAggregate {
	/**
	 * column size
	 * @var int
	 */
	private $size;
	private $index = 0;
	private $query;
	public function __construct(WP_Query $query, $size = 10) {
		$this->query = $query;
		$this->size = (int) max(0, $size);
	}
	/**
	 * @return WP_Query
	 */
	public function query() {
		return $this->query;
	}
	private function fragmentCount($fragmentSize, $totalSize) {
		$total = (int) $totalSize;
		$size = (int) max(0, $fragmentSize);
		if (!$total || !$size)
			return 0;
		$count = (int) ($total / $size);
		$count * $size != $total && $count++;				
		return $count;
	}
	private function fragmentSize($index, $fragmentSize, $totalSize) {
		$index = (int) max(0, $index);
		if (!$index)
			return 0;
		$count = $this->fragmentCount($fragmentSize, $totalSize);
		if ($index > $count)
			return 0;
		return $index === $count ? ($totalSize - ($count-1) * $fragmentSize) : $fragmentSize;			
	}
	public function columnSize($index) {
		return $this->fragmentSize($index, $this->size, $this->query->post_count);
	}
	/**
	 * @see Countable::count()
	 * @return int number of columns
	 */
	public function count() {
		return $this->fragmentCount($this->size, $this->query->post_count);
	}
	/**
	 * @return array
	 */
	public function columns() {
		$count = $this->count();
		$array = $count ? range(1, $count) : array();
		return array_map(array($this, 'columnSize'), $array);
	}
	/**
	 * @see IteratorAggregate::getIterator()
	 * @return traversable columns
	 */
	public function getIterator() {
		return new ArrayIterator($this->columns());
	}
}?>