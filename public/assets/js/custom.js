function isNumberKey(evt) {

    var charCode = (evt.which) ? evt.which : event.keyCode
    var isnumeric = false;
    if (charCode >= 48 && charCode <= 57)
        isnumeric = true;
    if (charCode == 46)
        isnumeric = true;
    if (charCode == 8)
        isnumeric = true;
    if (charCode == 9)
        isnumeric = true;
    if (charCode == 110)
        isnumeric = true;
    if (charCode == 190)
        isnumeric = true;
    if (charCode >= 37 && charCode <= 40)
        isnumeric = true;
    if (charCode >= 96 && charCode <= 105)
        isnumeric = true;

    return isnumeric;

}


function isAlphabatKey(evt) {

  var charCode = (evt.which) ? evt.which : event.keyCode
  var isnumeric = false;
  if (charCode >= 65 && charCode <= 90)
      isnumeric = true;
  if (charCode == 57)
      isnumeric = true;
  if (charCode == 48)
      isnumeric = true;
  if (charCode == 189)
      isnumeric = true;
  if (charCode == 55)
      isnumeric = true;
  if (charCode == 8)
      isnumeric = true;
  if (charCode == 46)
      isnumeric = true;
  if (charCode == 222)
      isnumeric = true;
  if (charCode == 17)
      isnumeric = false;
  if (charCode == 32)
      isnumeric = true;
  if (charCode == 9)
      isnumeric = true;
  return isnumeric;

}

