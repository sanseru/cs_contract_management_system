function rupiahToWords(number) {
  let words = {
    ones: [
      "",
      "satu",
      "dua",
      "tiga",
      "empat",
      "lima",
      "enam",
      "tujuh",
      "delapan",
      "sembilan",
    ],
    tens: [
      "",
      "sepuluh",
      "dua puluh",
      "tiga puluh",
      "empat puluh",
      "lima puluh",
      "enam puluh",
      "tujuh puluh",
      "delapan puluh",
      "sembilan puluh",
    ],
    hundreds: [
      "",
      "seratus",
      "dua ratus",
      "tiga ratus",
      "empat ratus",
      "lima ratus",
      "enam ratus",
      "tujuh ratus",
      "delapan ratus",
      "sembilan ratus",
    ],
    rupiah: ["", "ribu", "juta", "miliar", "triliun"],
  };

  if (typeof number === "number") {
    number = String(number);
  }

  let rupiahArr = number.split("").reverse();
  let result = [];

  for (
    let i = 0, rupiahIndex = 0;
    i < rupiahArr.length;
    i += 3, rupiahIndex++
  ) {
    let rupiahGroup = rupiahArr
      .slice(i, i + 3)
      .reverse()
      .join("");
    let wordsArr = [];

    if (rupiahGroup === "000") {
      continue;
    }

    if (rupiahGroup.length === 3 && rupiahGroup[0] !== "0") {
      let hundreds = Number(rupiahGroup[0]);
      wordsArr.push(words.hundreds[hundreds]);
    }

    if (rupiahGroup.length >= 2) {
      let tens = Number(rupiahGroup[rupiahGroup.length - 2]);
      let ones = Number(rupiahGroup[rupiahGroup.length - 1]);

      if (tens === 1) {
        let teen = Number(rupiahGroup.slice(-2));
        if (teen === 11) {
          wordsArr.push("sebelas");
        } else if (teen === 10) {
          wordsArr.push("sepuluh");
        } else {
          wordsArr.push(words.ones[teen % 10] + " belas");
        }
      } else {
        if (tens !== 0) {
          wordsArr.push(words.tens[tens]);
        }

        if (ones !== 0) {
          wordsArr.push(words.ones[ones]);
        }
      }
    } else {
      let ones = Number(rupiahGroup[rupiahGroup.length - 1]);
      if (ones !== 0) {
        wordsArr.push(words.ones[ones]);
      }
    }

    if (rupiahIndex > 0 && wordsArr.length > 0) {
      wordsArr.push(words.rupiah[rupiahIndex]);
    }

    result.unshift(wordsArr.join(" "));
  }

  return result.join(" ");
}

function currencyToWords(currency) {
  var currencyArray = currency.toString().split(",");

  var amount = parseInt(currencyArray.join(""));

  var currencyWord = "";

  switch (currencyArray[0]) {
    case "IDR":
      currencyWord = "rupiah";
      break;
    default:
      currencyWord = "";
  }

  var amountWord = rupiahToWords(amount);

  if (amountWord.trim() === "") {
    amountWord = "nol";
  }

  var result = "Total: " + amountWord + " " + currencyWord + " Rupiah";

  return result;
}

$("#contract_id").change(function () {
  var contractId = $(this).val();
  $.ajax({
    url: "/client/get-client",
    data: { id: contractId },
    method: "GET",
    dataType: "json",
    success: function (response) {
      // handle success response here
      $("#client_name").val(response.name);
      $("#client_id").val(response.id);
    },
    error: function (error) {
      // handle error response here
      alert(error.responseText);
    },
  });
});

$(document).ready(function () {
  // Initialize Select2
  $("#rate_id").select2();

  // Handle item_id change event
  $("#item_id").on("change", function () {
    var itemId = $(this).val();
    console.log(itemId);
    // Make an AJAX request to fetch select options based on item_id
    $.ajax({
      url: "/costing/fetch-options-unit-rate", // Replace with the actual URL to fetch select options
      type: "GET",
      data: { item_id: itemId },
      dataType: "json",
      success: function (response) {
        // Clear existing options
        $("#rate_id").empty();

        $("#rate_id").append(
          $("<option></option>").attr("value", "").text("Select unit Rate...")
        );

        // Add new options based on the response
        $.each(response, function (key, value) {
          $("#rate_id").append(
            $("<option></option>").attr("value", key).text(value)
          );
        });
        // Refresh Select2 to reflect the updated options
        $("#rate_id").trigger("change");
      },
      error: function () {
        console.log("Error occurred while fetching select options.");
      },
    });
  });
});
