/**
 * Common functions
 */

$(document).ready(function() {
    // Hide flash messages block
    $(".flash_messages .close").click(function(){
        $(".flash_messages").fadeOut();
    });

});


/**
 * Update cart data after product added.
 */
function reloadSmallCart()
{
    $("#cart").load(urlLang+'/cart/renderSmallCart');
}

function reloadPopupCart()
{
    $("#popup-cart").load(urlLang+'/cart/renderPopupCart');
}

/**
 * Add product to cart from list
 * @param data
 * @param textStatus
 * @param jqXHR
 * @param redirect
 */
function processCartResponseFromList(data, textStatus, jqXHR, redirect)
{
    var productErrors = $('#productErrors');
    if(data.errors)
    {
    	$('#notavailable-modal').arcticmodal({
            overlay: {
                css: {
                    backgroundColor: '#000',
                    opacity: .5
                }
            }
        });
    	//$.jGrowl(data.errors);
        /*window.location = redirect*/
    }else{
        reloadSmallCart();
        reloadPopupCart();
        $.jGrowl(jgrowlCheckout, {position:"bottom-right"});
        
        $('#cart-modal').arcticmodal({
            overlay: {
                css: {
                    backgroundColor: '#000',
                    opacity: .5
                }
            }
        });
        
    }
}

function processCartResponseFromCart(data, textStatus, jqXHR, redirect)
{
    var productErrors = $('#productErrors');
    if(data.errors)
    {
    	$('#notavailable-modal').arcticmodal({
            overlay: {
                css: {
                    backgroundColor: '#000',
                    opacity: .5
                }
            }
        });
    }
    else{
        $.jGrowl(jgrowlCheckout, {position:"bottom-right"});
        if(redirect.length > 0){
            location.reload();
        }
        else{
            reloadSmallCart();
            reloadPopupCart();
        }
    }
}
function applyInPage(el){
    console.log($(el).val());
    window.location = $(el).val();
}

function applyCategorySorter(el)
{
    window.location = $(el).val();
}

function getCitiesList(region_id, no_redirect, lang_id, lang_code) {
    $.post(
        '/site/cities/',
        {
            region_id: region_id,
            no_redirect: no_redirect,
            language_id: lang_id,
            language_code: lang_code
        },
        function (data) {
            $('.pr-regions').css('display', 'none');
            $('.pr-cities').css('display', 'block');
            if(data.length > 0){
                $('.hrc-content').html(data);
            }
        }
    );
}

function showRegions() {
    $('.hrc-content').html('');
    $('.pr-cities').css('display', 'none');
    $('.pr-regions').css('display', 'block');
}