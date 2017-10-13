<style>
.rate_widget {
    border:     1px solid #CCC;
    overflow:   visible;
    padding:    10px;
    position:   relative;
    width:      180px;
    height:     32px;
}
.ratings_stars {
    background: url('css/images/empty_star.png') no-repeat;
    float:      left;
    height:     28px;
    padding:    2px;
    width:      32px;
}
.ratings_vote {
    background: url('css/images/star_full.png') no-repeat;
}
.ratings_over {
    background: url('css/images/star_full.png') no-repeat;
}
.total_votes {
    background: #eaeaea;
    top: 58px;
    left: 0;
    padding: 5px;
    position:   absolute;  
} 
.movie_choice {
    font: 10px verdana, sans-serif;
    margin: 0 auto 40px auto;
    width: 180px;
}
</style>

<style>
$('.ratings_stars').hover(
    // Handles the mouseover
    function() {
        $(this).prevAll().andSelf().addClass('ratings_over');
        $(this).nextAll().removeClass('ratings_vote'); 
    },
    // Handles the mouseout
    function() {
        $(this).prevAll().andSelf().removeClass('ratings_over');
        set_votes($(this).parent());
    }
);
</style>

<div class='movie_choice'>
    Rate: Raiders of the Lost Ark
    <div id="r1" class="rate_widget">
        <div class="ratings_stars"></div>
        <div class="star_2 ratings_stars"></div>
        <div class="star_3 ratings_stars"></div>
        <div class="star_4 ratings_stars"></div>
        <div class="star_5 ratings_stars"></div>
        <div class="total_votes">vote data</div>
    </div>
</div>
 
<div class='movie_choice'>
    Rate: The Hunt for Red October
    <div id="r2" class="rate_widget">
        <div class="star_1 ratings_stars"></div>
        <div class="star_2 ratings_stars"></div>
        <div class="star_3 ratings_stars"></div>
        <div class="star_4 ratings_stars"></div>
        <div class="star_5 ratings_stars"></div>
        <div class="total_votes">vote data</div>
    </div>
</div>