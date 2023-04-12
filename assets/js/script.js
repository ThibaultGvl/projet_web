document.getElementById('search_form')
  ?.addEventListener('submit', function (event) {
    event.preventDefault()

    let searchInput = document.getElementById('search_input')

    if (searchInput.value) {
      this.submit()
    }
  })


const emailCheck = email => /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-z]{2,}$/.test(
  email)
const emailErrorContainer = document.getElementById(
  'email_error',
)
let emailHasError = false
const emailInput = document.getElementById('email')
const emailListenerCallback = () => {
  if (emailCheck(emailInput.value)) {
    emailErrorContainer.innerText = ''
    emailInput.classList.remove('error')
    emailHasError = false
  } else {
    emailErrorContainer.innerText = 'L\'email n\'a pas le bon format'
    emailErrorContainer.style.color = 'red'
    emailInput.style.backgroundColor = 'rgba(255, 0, 0, 0.1)'
    emailInput.style.borderColor = 'red'
    emailInput.classList.add('error')
    emailHasError = true
  }
}
let commentHasError = false
let commentInput = document.getElementById('commentaire')
let commentError = document.getElementById('comment_error')
const commentListenerCallback = () => {
  if (commentInput.value.length < 10) {
    commentError.innerText = 'Votre commentaire doit contenir plus de 10 charactères'
    commentError.style.color = 'red'
    commentInput.style.backgroundColor = 'rgba(255, 0, 0, 0.1)'
    commentInput.style.borderColor = 'red'
    commentInput.classList.add('error')
    commentHasError = true
  } else {
    commentError.innerText = ''
    commentInput.style.backgroundColor = ''
    commentInput.style.borderColor = ''
    commentInput.classList.remove('error')
    commentHasError = false
  }
}

document.getElementById('email_form')
  ?.addEventListener('submit', function (event) {
    event.preventDefault()

    emailListenerCallback()
    emailInput.addEventListener('input', emailListenerCallback, commentListenerCallback)

    commentListenerCallback()
    commentInput.addEventListener('input', commentListenerCallback, emailListenerCallback)

    if (!emailHasError && !commentHasError) {
      this.submit()
    }
  })


const affichBtn = document.getElementById('affich_btn');
affichBtn.addEventListener('click', () => {
    const page = parseInt(affichBtn.getAttribute('data-page')); // récupérer le numéro de page actuel
    const url = `./assets/php/loadAlbum.php?page=${page}`; // construire l'URL pour la requête AJAX
    fetch(url)
        .then(response => response.json())
        .then(albums => {
            console.log(albums); // afficher le contenu de la variable "albums" dans la console du navigateur
            affichBtn.setAttribute('data-page', page + 1);
        })
        .catch(error => {
            //console.error(error);
            console.log(error.message);
        });
});