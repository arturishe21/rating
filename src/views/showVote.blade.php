<div data-id="{{ $page->id }}" data-model = "{{Crypt::encrypt(get_class($page))}}" class="reyting">
    <span data-jq-rating
        data-jq-rating-editable="true"
        data-jq-rating-value="{{$thisRating}}"
        data-jq-rating-stars-count="5"
        data-jq-rating-based-on="5"
        >
        <input class="reyting_input" type="hidden" data-jq-rating-grade />
    </span>
    <div class="message"></div>
</div>
