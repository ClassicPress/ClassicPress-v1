<?php

/**
 * @group formatting
 * @group datetime
 */
class Tests_Formatting_Date extends WP_UnitTestCase {

	/**
	 * Unpatched, this test passes only when Europe/London is not observing DST.
	 *
	 * @see https://core.trac.wordpress.org/ticket/20328
	 */
	function test_get_date_from_gmt_outside_of_dst() {
		update_option( 'timezone_string', 'Europe/London' );
		$local = '2012-01-01 12:34:56';
		$gmt   = $local;
		$this->assertSame( $local, get_date_from_gmt( $gmt ) );
	}

	/**
	 * Unpatched, this test passes only when Europe/London is observing DST.
	 *
	 * @see https://core.trac.wordpress.org/ticket/20328
	 */
	function test_get_date_from_gmt_during_dst() {
		update_option( 'timezone_string', 'Europe/London' );
		$gmt   = '2012-06-01 12:34:56';
		$local = '2012-06-01 13:34:56';
		$this->assertSame( $local, get_date_from_gmt( $gmt ) );
	}

	/**
	 * @see https://core.trac.wordpress.org/ticket/20328
	 */
	function test_get_gmt_from_date_outside_of_dst() {
		update_option( 'timezone_string', 'Europe/London' );
		$local = '2012-01-01 12:34:56';
		$gmt   = $local;
		$this->assertSame( $gmt, get_gmt_from_date( $local ) );
	}

	/**
	 * @see https://core.trac.wordpress.org/ticket/20328
	 */
	function test_get_gmt_from_date_during_dst() {
		update_option( 'timezone_string', 'Europe/London' );
		$local = '2012-06-01 12:34:56';
		$gmt   = '2012-06-01 11:34:56';
		$this->assertSame( $gmt, get_gmt_from_date( $local ) );
	}

	/**
	 * @see https://core.trac.wordpress.org/ticket/34279
	 */
	function test_get_date_and_time_from_gmt_no_timezone() {
		$local = '2012-01-01 12:34:56';
		$gmt   = $local;
		$this->assertSame( $gmt, get_date_from_gmt( $local ) );
	}

	/**
	 * @see https://core.trac.wordpress.org/ticket/34279
	 */
	function test_get_gmt_from_date_no_timezone() {
		$gmt  = '2012-12-01 00:00:00';
		$date = '2012-12-01';
		$this->assertSame( $gmt, get_gmt_from_date( $date ) );
	}

	/**
	 * @see https://core.trac.wordpress.org/ticket/34279
	 */
	function test_get_gmt_from_date_short_date() {
		update_option( 'timezone_string', 'Europe/London' );
		$local = '2012-12-01';
		$gmt   = '2012-12-01 00:00:00';
		$this->assertSame( $gmt, get_gmt_from_date( $local ) );
	}

	/**
	 * @see https://core.trac.wordpress.org/ticket/34279
	 */
	function test_get_gmt_from_date_string_date() {
		update_option( 'timezone_string', 'Europe/London' );
		$local = 'now';
		$gmt   = gmdate( 'Y-m-d H:i:s' );
		$this->assertEqualsWithDelta( strtotime( $gmt ), strtotime( get_gmt_from_date( $local ) ), 2, 'The dates should be equal' );
	}

	/**
	 * @see https://core.trac.wordpress.org/ticket/34279
	 */
	function test_get_gmt_from_date_string_date_no_timezone() {
		$local = 'now';
		$gmt   = gmdate( 'Y-m-d H:i:s' );
		$this->assertEqualsWithDelta( strtotime( $gmt ), strtotime( get_gmt_from_date( $local ) ), 2, 'The dates should be equal' );
	}
}
