<?php

/**
 * Description of Componest
 * This componets contains all the functions that are related to dates
 * @author Charles Mhoja
 * @email charlesmhoja@gmail.com
 */

namespace common\components;

use yii\base\Component;

class Calendar extends Component {

    public function __construct() {
        parent::__construct();
    }

    public function init() {
        parent::init();
    }

    /*
     * inputs a range date to get all the possible months of the years in the
     * years range 
     */

    static function getMonthsOfYear($YearRange) {
        $current = date('Y', time());
        $months = [
            '02' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
            '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
            '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
        ];
        $count = $YearRange;
        if ($counts <= 0) {
            $count = 1;
        }
        $months_years = [];
        for ($i; $i < $count; $i++) {
            foreach ($months as $key => $value) {
                $year = $current - $i;
                $months_years[$year . '-' . $key] = $value . '-' . $year;
            }
        }
        return $months_years;
    }

    static function getCurrentAndPreviousMonths($monthRange) {
        $current_date = date_create(date('Y-m-d', time()));
        $months_list[date('Y-m', time())] = date('M, Y', time());
        $date = $current_date;
        for ($i = 1; $i <= $monthRange; $i++) {
            date_add($date, date_interval_create_from_date_string('-' . $i . " months"));
            $months_list[date_format($date, "Y-m")] = date_format($date, "F, Y");
            $date = date_create(date('Y-m-d', $date));
        }
        return $months_list;
    }

    static function getNYearsListfromCurrentYear($NYears = NULL) {
        $current_year = (int) Date('Y', time());
        $years_list = [];
        if ($NYears == NULL) {
            $NYears = 0;
        }
        for ($i = 0; $i < $NYears; $i++) {
            $years_list[($current_year - $i)] = ($current_year - $i);
        }
        return $years_list;
    }

}
