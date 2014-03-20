(function($, _){
    _.declare('brx.CookiePolicy.Banner', $.brx.View, {
        
        nlsNamespace: 'brx.CookiePolicy.Banner',
        
        options:{
            name: 'John Smith'
        },
        
        postCreate: function(){
            console.log('widget warm-up');
        },
        
        buttonAcceptClicked: function(){
            this.ajax('/api/cookie-policy/accept/', {
                spinner: false,
                success: $.proxy(function(){
                    this.$el.hide();
                }, this)
            });
        },
        
        buttonDeclineClicked: function(){
            this.ajax('/api/cookie-policy/decline/', {
                data:{
                    flag: true
                },
                spinner: false,
                success: $.proxy(function(){
                    this.$el.hide();
                }, this)
            });
//            window.location = 'http://google.com';
        }
    });
}(jQuery, _));


