<!-- if i use get here it passes the query in the url - if i use post it does not pass it  -->
<!-- I use a mix of post and get (post-postback) because i want to show the result on the same time as the user write in the form-->
<form data-url="<?= $frm_search_url ?>" id="frm_search" action="/search-results" method="GET" class="flex gap-4 items-center w-full">
<label for="" class="">Search for order</label>  
<input name="query" type="text" 
  class="w-8/12 h-8 rounded-sm outline-none text-gray-900 " 
  placeholder="Search"
  oninput="search_orders()"
  onfocus="setTimeout(function() { document.querySelector('#query_results').classList.remove('hidden') }, 200)"
  onblur="setTimeout(function() { document.querySelector('#query_results').classList.add('hidden') }, 200);">

  <div id="query_results" 
  class="hidden absolute w-auto bg-zinc-800 border h-48 border-teal-200 text-gray-50 overflow-hidden overflow-y-visible mt-34 ml-30">  
  </div>
</form>