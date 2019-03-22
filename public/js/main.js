/* Search */

var products = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        wildcard: '%QUERY',
        url: path + '/search/typeahead?query=%QUERY'
    }
});

products.initialize();

$('#typeahead').typeahead({
    highlight: true
},{
    name: 'products',
    display: 'title',
    limit: 10,
    source: products
});

$('#typeahead').bind('typeahead:select', function(ev, suggestion){
    window.location = path + '/search/?s=' + encodeURIComponent(suggestion.title);
});

/* end Search */



/* Cart */

$('body').on('click', '.add-to-cart-link', function(e){
    e.preventDefault();

    var id = $(this).data('id'),
        qty = $('.quantity input').val() ? $('.quantity input').val() : 1,
        mod = $('.available select').val();
    // console.log(id, qty, mod);

    $.ajax({
        url: '/cart/add',
        data: {
            id: id,
            qty: qty,
            mod: mod
        },
        type: 'GET',
        success: function(res){
            showCart(res);
        },
        error: function(){
            alert('Ошибка! Невозможно добавить этот товар');
        }
    });
});

$('#cart .modal-body').on('click', '.del-item', function(){

    var id = $(this).data('id');
    $.ajax({
        url: '/cart/delete',
        data: {id: id},
        type: 'GET',
        success: function(res){
            showCart(res);
        },
        error: function(){
            alert('Ошибка!');
        }
    });
});

function showCart(cart)
{
    if ('<h3>Корзина пуста</h3>' == $.trim(cart)){
        $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'none');
    }else{
        $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'inline-block');
    }

    $('#cart .modal-body').html(cart);
    $('#cart').modal();

    if ($('.cart-sum').text()){
        $('.simpleCart_total').html( $('#cart .cart-sum').text() );
    }else{
        $('.simpleCart_total').text('Empty Cart');
    }

}

function getCart()
{
    $.ajax({
        url: '/cart/show',
        type: 'GET',
        success: function(res){
            showCart(res);
        },
        error: function(){
            alert('Ошибка! Невозможно отбазить корзину');
        }
    });
}

function clearCart()
{
    $.ajax({
        url: '/cart/clear',
        type: 'GET',
        success: function(res){
            showCart(res);
        },
        error: function(){
            alert('Ошибка! Не сегодня...')
        }
    });
}

/* Cart */


$('#currency').change(function(){
    window.location = 'currency/change?curr=' + $(this).val();
});

$('.available select').change(function(){
    var modeId = $(this).val(),
        color = $(this).find('option').filter(':selected').data('title'),
        price = $(this).find('option').filter(':selected').data('price');
        basePrice = $('#base-price').data('base');

    if (price){
        $('#base-price').text(symbolLeft + price + symbolRight);
    }else{
        $('#base-price').text(symbolLeft + basePrice + symbolRight);
    }
});