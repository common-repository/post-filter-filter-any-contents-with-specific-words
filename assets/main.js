{
    let flag_answer;
    function pf_save_button_clicked() {
        let save_button = jQuery("input[name='pf_submit_button']");
        const save_button_text = save_button.val();
        const url = save_button.data("ajax-url");
        let post_types = [];
        flag_answer = false;
        const words = jQuery("#pf-black-list").val();
        var modes = "wordsOnly";
        const action = jQuery("input[name='action-choice']:checked").val();
        const replace_word = jQuery("input[name='action-replace-word']").val();
        const replace_rb = jQuery("input[value='replace'][type = 'radio']");
        const strict_rb = jQuery("input[value='strict'][type = 'radio']");
        const wp_nonce = jQuery("input[id='wp-nonce']").val();
        let replace_word_flag =  true;
        if(strict_rb.is(':checked')) modes = "strict";
        if(replace_rb.is(':checked') && replace_word.length < 1) replace_word_flag = false;
        jQuery.each(jQuery(".pv-post-typle-select option:selected"), function () {

            post_types.push(jQuery(this).val());

        });
        if(words.length > 0 && action.length > 0 && post_types.length > 0 && replace_word_flag){
            save_button.prop('value',postfilter_main_js.saving);
            save_button.prop('disabled', true);
            blink();
            jQuery.ajax({
                url: url,
                dataType: 'html',
                data: {action: 'save_postfilter_settings', post_types: post_types, words: words, replace_word: replace_word, event: action, wp_nonce:wp_nonce, mode: modes},
                success: function (data) {
                    save_button.prop('value', save_button_text).prop('disabled', false);
                    jQuery.amaran({
                        content:{
                            bgcolor:'#27ae60',
                            color:'#fff',
                            message:postfilter_main_js.saved
                        },
                        theme:'colorful'
                    });
                    flag_answer = true;
                },
                error: function (data, ex) {
                    save_button.prop('value', save_button_text).prop('disabled', false);
                    jQuery.amaran({
                        content:{
                            bgcolor:'#ae0028',
                            color:'#fff',
                            message:postfilter_main_js.faild + " " + ex
                        },
                        theme:'colorful'
                    });
                    flag_answer = true;
                }

            });

        }else{

            jQuery.amaran({
                content:{
                    bgcolor:'#ae0028',
                    color:'#fff',
                    message:postfilter_main_js.emptyerror
                },
                theme:'colorful'
            });
            flag_answer = true;

        }

    }

    const blink = function () {
        jQuery("input[name='pf_submit_button']").animate({
            opacity: '0'
        }, function () {
            jQuery(this).animate({
                opacity: '1'
            }, function () {
                if (!flag_answer)
                    blink();
            });
        });
    };
}
function replace_word_activator (pointer) {
    const replace_word = jQuery("input[name = 'action-replace-word']");
    if(pointer.is(':checked') && pointer.val() === "replace") replace_word.prop('disabled', false);
    else replace_word.prop('disabled', true);


}

jQuery(document).ready(function () {

    const rbs = jQuery("input[type = 'radio']");
    const replace_rb = jQuery("input[type = 'radio'][value = 'replace']");
    replace_word_activator(replace_rb);
    rbs.click(function () {
        replace_word_activator(jQuery(this));
    });

});

