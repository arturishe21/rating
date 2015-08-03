<?php namespace  Vis\Ratings;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\View;
use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cache;

class Rating extends Eloquent {

    protected $table = 'ratings';

    public static $rules = array(
        'ip'=> 'required',
        'ratingspage_id' => 'required|numeric',
        'ratingspage_type' => 'required',
        'rating' => 'required|numeric',
    );

    protected $fillable = array('ratingspage_id', 'ratingspage_type', 'ip', 'rating', 'user_id');

    /*
     * get stars for vote
     * @param object $page this page
     *
     * @return html
     */
    public function showVote($page)
    {
        $thisRating = $this->getRatingAndCache($page);

        return View::make('rating::showVote', compact("page", "thisRating"));
    }

    /*
     * get stars no active
     * @param object $page
     *
     * @return html
     */
    public function showResult($page)
    {
        $thisRating = $this->getRatingAndCache($page);

        return View::make('rating::showResult', compact("thisRating"));
    }

    /*
     * get avg rating this page
     * @param object $page
     *
     * @return integer|float
     */
    private function getRatingAndCache($page)
    {

        $nameCache = get_class($page).$page->id;

        $ratingAvg = Cache::tags('rating')->rememberForever($nameCache, function() use ($page) {

            $ratingAvg = self::where("ratingspage_id", $page->id)
                ->where("ratingspage_type", 'like', get_class($page))
                ->avg("rating");

            return $ratingAvg;
        });


        return $ratingAvg;
    }

    /*
     * validation param for save
     * @param array $data
     *
     * @return boolen|json
     */
    public static function isNotValid(array $data)
    {
        $validator = Validator::make($data, Rating::$rules);

        if ($validator->fails()) {
            return Response::json(
                array(
                    "status" => "error",
                    "errors_messages" => $validator->messages()
                )
            );
        } else {
            return false;
        }
    }

    /*
     * check have already voted
     * @param array $data
     *
     * @return boolen
     */
    public static function isCheckIp(array $data)
    {
      $presentIp = self::where("ratingspage_id", $data['ratingspage_id'])
            ->where("ratingspage_type", 'like', $data['ratingspage_type'])
            ->where("ip", 'like',  $data['ip'])->count();

      if ($presentIp) {
          return true;
      } else {
          return false;
      }
    }

    public static function doClearCache()
    {
        Cache::tags('rating')->flush();
    }
}