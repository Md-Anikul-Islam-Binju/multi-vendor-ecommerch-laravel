var sizeattr = 1;

function size_fields() {

    sizeattr++;
    var objTo = document.getElementById('size_fields')
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass" + sizeattr);
    var rdiv = 'removeclass' + sizeattr;
    divtest.innerHTML = '<div class="row"><div class="col-sm-3 nopadding"><div class="form-group"> <input type="text" class="form-control" id="Schoolname" name="Schoolname[]" value="" placeholder="School name"></div></div><div class="col-sm-3 nopadding"><div class="form-group"> <input type="text" class="form-control" id="Major" name="Major[]" value="" placeholder="Major"></div></div><div class="col-sm-3 nopadding"><div class="form-group"> <input type="text" class="form-control" id="Degree" name="Degree[]" value="" placeholder="Degree"></div></div><div class="col-sm-3 nopadding"><div class="form-group"><div class="input-group"> <select class="form-control" id="educationDate" name="educationDate[]"><option value="">Date</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option> </select><div class="input-group-append"> <button class="btn btn-danger" type="button" onclick="remove_size_fields(' + sizeattr + ');"> <i class="fa fa-minus"></i> </button></div></div></div></div><div class="clear"></div></row>';

    objTo.appendChild(divtest)
}

function remove_size_fields(rid) {
    $('.removeclass' + rid).remove();
}