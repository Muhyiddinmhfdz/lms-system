const FormatNumber = function(number) {
    // format number 1000000 to 1,234,567
    return number.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

const FormatCurrency = function(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.
        
    // get input value
    var input_val = input.val();
        
    // don't validate empty input
    if (input_val === "") { return; }
        
    // original length
    var original_len = input_val.length;
      
    // initial caret position 
    var caret_pos = input.prop("selectionStart");
          
    // check for decimal
    if (input_val.indexOf(".") >= 0) {
      
        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");
      
        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);
      
        // add commas to left side of number
        left_side = CurrencyFormatting.FormatNumber(left_side);
      
        // validate right side
        right_side = CurrencyFormatting.FormatNumber(right_side);
          
        // On blur make sure 2 numbers after decimal
        // if (blur === "blur") {
        //     right_side += "00";
        // }
          
        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);
      
        // join number by .
        input_val = left_side + "." + right_side;
      
    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = CurrencyFormatting.FormatNumber(input_val);
        input_val = input_val;
          
        // final formatting
        // if (blur === "blur") {
        //     input_val += ".00";
        // }
    }
        
    // send updated string to input
    input.val(input_val);
      
    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}

const FormatCurrencyWhenOnLoad = function(numberStr) {
    numberStr += '';
    val = numberStr.split('.');
    val1 = val[0];
    val2 = val.length > 1 ? '.' + val[1] : '';
    var val_regex = /(\d+)(\d{3})/;
    while (val_regex.test(val1)) {
        val1 = val1.replace(val_regex, '$1' + ',' + '$2');
    }
    return val1 + val2;
}

const CurrencyFormattingOnLoad = function() {
    jQuery("input[data-type='currency']").each(function(){
        if(jQuery(this).val() != '') {
            var get_val_number = jQuery(this).val();
            jQuery(this).val(CurrencyFormatting.FormatCurrencyWhenOnLoad(parseFloat(get_val_number).toFixed(2)));
        }
    });

    jQuery(document).on('change keyup', 'input[data-type="currency"]', function() {
        CurrencyFormatting.FormatCurrency(jQuery(this));
    });
    jQuery(document).on('change blur', 'input[data-type="currency"]', function() {
        CurrencyFormatting.FormatCurrency(jQuery(this), "blur");
    });
}

const CurrencyFormatting = {
    CurrencyFormattingOnLoad,
    FormatNumber,
    FormatCurrency,
    FormatCurrencyWhenOnLoad
}

jQuery(document).ready(CurrencyFormatting.CurrencyFormattingOnLoad)

if(typeof module !== 'undefined'){
    module.exports = CurrencyFormatting;
}