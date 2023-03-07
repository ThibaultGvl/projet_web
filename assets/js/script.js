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

document.querySelector('form')
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
