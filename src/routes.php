<?php

if (Request::ajax()) {
    Route::post('/rating/add_vote', array(
            'uses' => 'Vis\Rating\RatingController@doAddVote')
    );
}