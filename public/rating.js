var Reyting = {

    init: function() {

        $('[data-jq-rating]').jqRating();

    }, //end init

    change: function(_this) {

        var data = {}
        id = parseInt(_this.data('id')),
            value = _this.find('.reyting_input').val();

        data['id'] = id;
        data['value'] = value;
        data['model'] = _this.data('model');

        $.post("/rating/add_vote",{data : data},function(response){

            if ( response.status == "error" ) {
                _this.find('.message').html("<span class='rating_error'>" + response.error_messages + "</span>");
            } else {
                _this.find('.message').html("<span class='rating_success'>" + response.ok_messages + "</span>");
            }
        },"json");

    }, //end change

    events: function() {
        $('.jq-rating-star').on('click',function() {
            var _this = $(this).closest('.reyting');
            Reyting.change(_this);
        });

    } //end events

}; //end Reyting

$(function(){
    Reyting.init();
    $('.jq-rating').click(function() {
        Reyting.change( $(this).closest('.reyting') );
    });
});