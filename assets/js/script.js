//Vérification de la validité de l'email rentré
const userLang = navigator.language || navigator.userLanguage;
const emailCheck = email => /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-z]{2,}$/.test(
  email)
const emailErrorContainer = document.getElementById(
  'email_error',
)
let emailHasError = false
const emailInput = document.getElementById('email')
const emailListenerCallback = () => {
  if (!emailCheck(emailInput.value)) {
    if (userLang.includes('fr')) {
      emailErrorContainer.innerText = 'L\'email n\'a pas le bon format'
    }
    else {
      emailErrorContainer.innerText = 'The email does not have the right format'
    }
    emailErrorContainer.style.color = 'red'
    emailInput.style.backgroundColor = 'rgba(255, 0, 0, 0.1)'
    emailInput.style.borderColor = 'red'
    emailHasError = true
  } else {
    emailErrorContainer.innerText = ''
    emailInput.style.backgroundColor = ''
    emailInput.style.borderColor = ''
    emailHasError = false
  }
}

//Vérification de la validité d'un commentaire 
let commentHasError = false
let commentInput = document.getElementById('commentaire')
let commentError = document.getElementById('comment_error')
const commentListenerCallback = () => {
  if (commentInput.value.length < 10) {
    if (userLang.includes('fr')) {
      commentError.innerText = 'Votre commentaire doit contenir plus de 10 charactères'
    }
    else {
      commentError.innerText = 'Your comment must contain more than 10 characters'
    }
    commentError.style.color = 'red'
    commentInput.style.backgroundColor = 'rgba(255, 0, 0, 0.1)'
    commentInput.style.borderColor = 'red'
    commentHasError = true
  } else {
    commentError.innerText = ''
    commentInput.style.backgroundColor = ''
    commentInput.style.borderColor = ''
    commentHasError = false
  }
}

//Vérification de la validité d'un nom
let nameHasError = false
let nameInput = document.getElementById('name')
let nameError = document.getElementById('name_error')
const nameListenerCallback = () => {
  if (!nameInput.value && nameInput.value.length == 0) {
    if (userLang.includes('fr')) {
      nameError.innerText = 'Veuillez entrer un nom'
    }
    else {
      nameError.innerText = 'Please enter a name'
    }
    nameError.style.color = 'red'
    nameInput.style.backgroundColor = 'rgba(255, 0, 0, 0.1)'
    nameInput.style.borderColor = 'red'
    nameHasError = true
  } else {
    nameError.innerText = ''
    nameInput.style.backgroundColor = ''
    nameInput.style.borderColor = ''
    nameHasError = false
  }
}

//On écoute la tentative d'envoie, si tous les inputs sont valides on envoie le formulaire
document.getElementById('email_form')
  ?.addEventListener('submit', function (event) {
    event.preventDefault()

    emailListenerCallback()
    emailInput.addEventListener('input', emailListenerCallback, commentListenerCallback, nameListenerCallback)

    commentListenerCallback()
    commentInput.addEventListener('input', commentListenerCallback, emailListenerCallback, nameListenerCallback)

    nameListenerCallback()
    nameInput.addEventListener('input', nameListenerCallback, commentListenerCallback, emailListenerCallback)

    if (!emailHasError && !commentHasError && !nameHasError) {
      this.submit()
    }
})

//On vérifie que l'input n'est pas vide avant l'envoie
document.getElementById('search_form')
  ?.addEventListener('submit', function (event) {
    event.preventDefault()

    if (document.getElementById('search_input').value.length > 0) {
      this.submit()
      
    }
    else {
      document.getElementById('search_error').innerText = 'Veuillez saisir un champ'
      document.getElementById('search_error').style.color = 'red'
    }
})

//Fonction qui permet de créer un nouvel élément pour un album pris en paramètre
function createAlbumElement(album) {
  const albumElem = document.createElement('a')
  albumElem.href = 'details.php?id=' + album.id
  
  const imgElem = document.createElement('img')
  imgElem.src = album.uri
  
  if (userLang.includes('fr')) {
    imgElem.alt = 'Pochette de l\'album : ' + album.title
  }
  else {
    imgElem.alt = 'Cover of album : ' + album.title
  }
  albumElem.appendChild(imgElem)
  
  const titElem = document.createElement('h2')
  titElem.textContent = album.title
  albumElem.appendChild(titElem)
  
  return albumElem
}

//Lancement d'une requete AJAX lors du clic sur le bouton "Afficher plus d'albums", on demande à loadAlbum les données on les récupère en json et on affiche les 3 nouveux albums sur la page
const affichBtn = document.getElementById('affich_btn')
if (affichBtn) {
 affichBtn.addEventListener('click', async (event) => {
    event.preventDefault()
    const page = parseInt(affichBtn.getAttribute('data-page'))
    const data = { page: page }
    const url = `assets/php/loadAlbum.php`
    try {
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      if (response.ok) {
        const albums = await response.json()
        const list = document.querySelector('main ul')
        const elem = document.createElement('li')
        for (const albumJson of albums) {
          const album = JSON.parse(albumJson)
          const albumElem = createAlbumElement(album)
          elem.appendChild(albumElem)
        }
        list.insertBefore(elem, affichBtn)
        affichBtn.setAttribute('data-page', page + 1)
      } else {
        console.error(response.statusText)
      }
    } catch (error) {
      console.error(error.message)
    }
  });
}
//On vérifie si le paramètre queryde l'url existe, si c'est le cas il n'est pas possible d'afficher plus d'albums : nous sommes en mode recherche
if (affichBtn) {
  const urlParams = new URLSearchParams(window.location.search)
  const queryParam = urlParams.get('query')
  if (queryParam != null) {
    affichBtn.style.display = 'none'
  }
  else {
    affichBtn.style.display = ''
  }
}