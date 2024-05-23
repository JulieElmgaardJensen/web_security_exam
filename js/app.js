// ############################################################
async function is_username_available(){
  const frm = event.target.form
  const conn = await fetch('api/api-username-available.php', {
    method: "POST",
    body: new FormData(frm)
  })
  if( ! conn.ok ){
    console.log('username not available')
    document.querySelector('#msg_username_not_available').classList.remove('hidden')
    return
  }
  console.log('username available')
}


// ############################################################
async function is_email_available(){
  const frm = event.target.form
  const conn = await fetch('api/api-is-email-available.php', {
    method: "POST",
    body: new FormData(frm)
  })
  if( ! conn.ok ){ 
    console.log('email not available')
    document.querySelector('#msg_email_not_available').classList.remove('hidden')
    return
  }
  console.log('email available')
}


//############################################################
async function delete_user() {
  const frm = event.target
  console.log(frm)
  const conn = await fetch('api/api-admin-delete-user.php', {
    method : "POST",
    body : new FormData(frm)
  })
  const response = await conn.json()
  console.log(response)
  frm.parentElement.remove() 
}

//############################################################
function confirm_delete_user() {
  const confirmed = confirm('This is a permanent delete, are you sure you want to continue?');
  if (confirmed) {
    delete_user();
  } else {
  }
}


//############################################################
async function delete_own_user() {
  const frm = event.target;
  console.log(frm);
  
  try {
    const conn = await fetch('api/api-delete-user.php', {
      method: 'POST',
      body: new FormData(frm),
    });

    if (!conn.ok) {
      throw new Error(`HTTP error! Status: ${conn.status}`);
    }

    if (conn.status !== 204) {
      const response = await conn.json();
      console.log(response);
    }

    frm.parentElement.remove();
  } catch (error) {
    console.error('Error deleting user:', error);
  }
  location.href = '/logout'
}


//############################################################
function confirm_delete_own_user() {
  const confirmed = confirm('Are you sure you wanna leave FoodFly? 😔');
  if (confirmed) {
    delete_own_user();
  } else {
  }
}


//############################################################
async function delete_order() {
  const frm = event.target
  console.log(frm)
  const conn = await fetch('api/api-admin-delete-order.php', {
    method : "POST",
    body : new FormData(frm)
  })
  const response = await conn.json()
  console.log(response)
  frm.parentElement.remove() 
}

//############################################################
function confirm_delete_order() {
  const confirmed = confirm('This is a permanent delete, are you sure you want to continue?');
  if (confirmed) {
    delete_order();
  } else {
  }
}


//############################################################
async function toggle_blocked(user_id, user_is_blocked){
  console.log('user_id', user_id);
  console.log('user_is_blocked', user_is_blocked)

  const button = event.target;

  if (user_is_blocked == 0) {
      button.innerHTML = 'Blocked';
      button.classList.remove('text-green-500');
      button.classList.add('text-red-500');
  } else {
      button.innerHTML = 'Unblocked';
      button.classList.remove('text-red-500');
      button.classList.add('text-green-500');
  }

  const conn = await fetch(`api/api-toggle-user-blocked.php?user_id=${user_id}&user_is_blocked=${user_is_blocked}`)
  const data = await conn.text()
  console.log(data)

}


// ############################################################
async function update_user(user_id) {

  const frm = event.target
  console.log(frm)

  const formData = new FormData(frm);
  formData.append('user_id', user_id);

  const conn = await fetch('/api/api-update-user.php', {
      method: "POST",
      body: formData
  });

  if (!conn.ok) {
    Swal.fire({
      icon: 'error',
      title: 'Something went wrong!',
    })
    return
  }
  Swal.fire({
    toast: 'false',
    icon: 'success',
    timer: '2000',
    title: 'Your profile is now updated!',
  })
  console.log('User is updated')
  //alert('Your profile is now updated!');
}


// ############################################################
async function signup() {
  const frm = event.target
  console.log(frm)
  const conn = await fetch('api/api-signup.php', {
    method: "POST",
    body: new FormData(frm)
  })

  const data = await conn.text()
  console.log(data)

  if (!conn.ok) {
    Swal.fire({
      icon: 'error',
      title: 'Sorry.. We had trouble signing you up. Please try again!',
    })
    return
  }
  location.href = '/login'
}


// ############################################################
async function login() {
  const frm = event.target;
  console.log(frm);

  const conn = await fetch('api/api-login.php', {
    method: "POST",
    body: new FormData(frm),
  })

  const data = await conn.json();
  console.log(data);

  if (!conn.ok) {
    document.getElementById('login_error_message').innerHTML = 'Login not succeeded, please try again.';
    Swal.fire({
      icon: 'error',
      title: 'Ups, something went wrong in the login, please try again!',
    });
    return;
  };


  if(data.user_role === 'admin') {
    location.href = `/users`;
  }else {  location.href = `/profile?user_id=${data.user_id}`;}
}


// ############################################################
var timer_search = ''

function search_users(){
  clearTimeout(timer_search)

  timer_search = setTimeout(async function(){ 
    const frm = document.querySelector('#frm_search')
    const url = frm.getAttribute('data-url')
    console.log('URL: ', url)
    // await fetch-anmodning til den angivne API data url med formen
    const conn = await fetch(`/api/${url}`, {
      method : "POST",
      body : new FormData(frm)
    })
    //konvertere til json
    const data = await conn.json()

    //Opretter variabel til id'et
    const query_results_container = document.querySelector('#query_results');
    query_results_container.innerHTML = '';

    // hvis der er data, vil den loop igennem hver user og give den div_user 
    if (data.length > 0) {
      data.forEach(user => {
        let div_user = `
        <a href="/user?user_id=${user.user_id}">
          <div class="grid grid-cols-4 p-2">
            <div class="">${user.user_id}</div>
            <div class="">${user.user_name}</div>
            <div class="">${user.user_last_name}</div>
          </div>
          </a>
        `;
        //indsætter div_user html'en i container variablen
        query_results_container.insertAdjacentHTML('afterbegin', div_user);
      });
    } else {
      //hvis ingen resultater vises denne besked
      query_results_container.innerHTML = `<div class="p-2"><p>No results found.</p></div>`;
    }
  }, 500);
}


// ############################################################
function search_orders(){
  clearTimeout(timer_search)

  timer_search = setTimeout(async function(){ 
    const frm = document.querySelector('#frm_search')
    const url = frm.getAttribute('data-url')
    console.log('URL: ', url)
    const conn = await fetch(`/api/${url}`, {
      method : "POST",
      body : new FormData(frm)
    })
    const data = await conn.json()

    const query_results_container = document.querySelector('#query_results');
    query_results_container.innerHTML = '';

    if (data.length > 0) {
      data.forEach(order => {
        let div_order = `
        <a href="/order?order_id=${order.order_id}">
          <div class="grid grid-cols-4 p-2">
            <div class="">${order.order_id}</div>
            <div class="">${order.user_name}</div>
            <div class="">${order.user_last_name}</div>
            <div class="">${order.product_name}</div>
          </div>
          </a>
        `;
        query_results_container.insertAdjacentHTML('afterbegin', div_order);
      });
    } else {
      query_results_container.innerHTML = `<div class="p-2"><p>No results found.</p></div>`;
    }
  }, 500);
}


// ############################################################
function search_own_orders(){
  clearTimeout(timer_search)

  timer_search = setTimeout(async function(){ 
    const frm = document.querySelector('#frm_search')
    const url = frm.getAttribute('data-url')
    console.log('URL: ', url)
    const conn = await fetch(`/api/${url}`, {
      method : "POST",
      body : new FormData(frm)
    })
    
    const data = await conn.json()

    const query_results_container = document.querySelector('#query_results');
    query_results_container.innerHTML = '';
 
    if (data.length > 0) {
      data.forEach(order => {
        let div_order = `
          <div class="grid grid-cols-4 p-2">
            <div class="">${order.order_id}</div>
            <div class="">${order.user_name}</div>
            <div class="">${order.user_last_name}</div>
            <div class="">${order.product_name}</div>
          </div>
        `;
        query_results_container.insertAdjacentHTML('afterbegin', div_order);
      });
    } else {
      query_results_container.innerHTML = `<div class="p-2"><p>No results found.</p></div>`;
    }
  }, 500);
}


// ############################################################
function search_partners_orders(){
  clearTimeout(timer_search)

  timer_search = setTimeout(async function(){ 
    const frm = document.querySelector('#frm_search')
    const url = frm.getAttribute('data-url')
    console.log('URL: ', url)
    const conn = await fetch(`/api/${url}`, {
      method : "POST",
      body : new FormData(frm)
    })
    
    const data = await conn.json()

    const query_results_container = document.querySelector('#query_results');
    query_results_container.innerHTML = '';
 
    if (data.length > 0) {
      data.forEach(order => {
        let div_order = `
          <div class="grid grid-cols-4 p-2">
            <div class="">${order.order_id}</div>
            <div class="">${order.user_name}</div>
            <div class="">${order.user_last_name}</div>
            <div class="">${order.product_name}</div>
          </div>
        `;
        query_results_container.insertAdjacentHTML('afterbegin', div_order);
      });
    } else {
      query_results_container.innerHTML = `<div class="p-2"><p>No results found.</p></div>`;
    }
  }, 500);
}