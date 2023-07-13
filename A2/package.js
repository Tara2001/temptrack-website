document.getElementById('login').addEventListener('click', getData);

function getData() {
  // console.log('test');

  fetch('fname','lname','email','password','password')
    .then(res => res.json())
    .then(data => {
      console.log(data);
    });

}