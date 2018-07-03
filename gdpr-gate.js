  // console.log fallback
        if (typeof console === 'undefined') {
          window.console = {
            log: function() {}
          };
        }
        $(function(){

            $("#confirm").on('click',function(e){
                e.preventDefault();
                var inFiftyMinutes = new Date(new Date().getTime() + 15 * 60 * 1000);
                // valid for whole domain --> does not work for Multisite?!?!
                // 2DO: use subdomain Cookies.set('name', 'value', { domain: 'subdomain.site.com' });
                Cookies.set('gdpr_gate_never_gonna_give_you_up', 'confirmed', { expires: inFiftyMinutes });

                if(typeof(Cookies.get("gdpr_gate_never_gonna_give_you_up"))==="undefined"){
                    // cookie was not set, display error message
                    alert('Cookie could not be set. Please activate cookies in your browser.')
                }
                else{
                    if(Cookies.get("gdpr_gate_never_gonna_give_you_up")==="confirmed"){
                        // reload the page
                        console.log('GDPR-gate: Cookie was set, reload the page to show content to user.')
                        location.reload();
                    }
                }
                
            });

            
        });