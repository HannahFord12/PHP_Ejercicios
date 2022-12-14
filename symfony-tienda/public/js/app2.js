(function(){
    const cartModal=$("#cart-modal");
    $("a.open-cart-modal").click(function(event){
        event.preventDefault();
        const id=$( this ).attr('data-id');
        const href= `/api/show/${id}`;
        $.get( href, function(data) {
            $(cartModal).find( ".name" ).text(data.name);
            $(cartModal).find( "#imagen" ).attr("src", "/img/" + data.photo);
            cartModal.modal('show');
        })
    });
    $(".closeCart").click(function(e){
        cartModal.modal('hide');
    })
})();