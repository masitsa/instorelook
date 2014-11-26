 
        <div class="content light-grey-background">
        	<div class="container">
        		<div class="search-flights">
                                
                                <div class="form-group">
                                    <label for="vendor_store_surburb" class="col-sm-3 control-label">Surburb <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="vendor_store_surburb" name="states" autocomplete="off" data-provide="typeahead"> 
                                    </div>
                                </div>
                </div>
           </div>
       </div>
<script type="text/javascript" src="<?php echo base_url().'assets/themes/typeahead/bootstrap3-typeahead.min.js';?>"></script>
<script type="text/javascript">

$( document ).ready(function() {
	
var substringMatcher = function(strs) {
	  return function findMatches(q, cb) {
		var matches, substrRegex;
	 
		// an array that will be populated with substring matches
		matches = [];
	 
		// regex used to determine if a string contains the substring `q`
		substrRegex = new RegExp(q, 'i');
	 
		// iterate through the pool of strings and for any string that
		// contains the substring `q`, add it to the `matches` array
		$.each(strs, function(i, str) {
		  if (substrRegex.test(str)) {
			// the typeahead jQuery plugin expects suggestions to a
			// JavaScript object, refer to typeahead docs for more info
			matches.push({ value: str });
		  }
		});
	 
		cb(matches);
	  };
	};
	 
	var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
	  'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
	  'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
	  'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
	  'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
	  'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
	  'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
	  'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
	  'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
	];
	 
	$('#vendor_store_surburb').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},
	{
	  name: 'states',
	  displayKey: 'value',
	  source: substringMatcher(states)
	});
});
</script>