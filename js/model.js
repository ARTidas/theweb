var base_currency = 'HUF'

function initializeJavaScript() {
  console.log('Model JS script ready to work on DOM...');
  console.log('Initializing currencyExchange function...');
  currencyExchange();
  console.log('Model JS script work done. Bye!');
};

$(document).ready(initializeJavaScript());

function currencyExchange() {
  total_amount_in_base_currency = 0.0;
  $('#model_list > tbody > tr > td[name="uom"]').each(function() {
    target_currency = $(this).html().trim();
    fx_rate = getFXRate(base_currency, $(this).html().trim());
    value = $(this).parent().find('td[name="amount"]').html().trim().replace(/,/g , '');
    total_amount_in_base_currency += value * fx_rate;
    //console.log('FX rate: ' + target_currency + base_currency + '=' + fx_rate);
    //console.log('Found FX value: ' + value + ' ' + target_currency)
    if (target_currency == base_currency) {
      $(this).parent().find('td[name="amount"]').html(
        (formatNumericString(value) + ' ' + base_currency)
      );
    }
    else {
      $(this).parent().find('td[name="amount"]').html(
        (formatNumericString(value * fx_rate)) + ' ' + base_currency + ' (' + (formatNumericString(value)) + ' ' + target_currency + ')'
      );
    }
  });

  $('table#model_list > tfoot > tr > td[name="total"]').html(formatNumericString(total_amount_in_base_currency) + ' ' + base_currency);
  $('table#model_list > tfoot > tr > td[name="uom"]').html(base_currency);
};


function getFXRate(base_currency, target_currency) {
  selector = $('p#fx_rates > span#fx_rate_' + target_currency + base_currency);
  if (typeof(selector) === 'undefined') {
    return 1.0
  }
  if (typeof(selector.html()) === 'undefined') {
    return 1.0
  }

  return selector.html().trim();
};

function formatNumericString(input_string) {
    var n= input_string.toString().split(".");
    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    /*return n.join(".");*/
    return n[0]; /*No need for the decimals for now... [artidas]*/
}
