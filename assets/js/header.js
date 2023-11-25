const menu = document.getElementById('menu')
menu.addEventListener('click',e=> {
    if(e.target.tagName === 'SPAN' && e.target.classList.contains('dropdown')) {
        e.target.parentNode.children[1].classList.toggle('active')
        e.target.parentNode.classList.toggle('toggle')
    }
})

const verMenu = document.querySelector('.ver-menu')
verMenu.addEventListener('click',() => {
    document.querySelector('.main-nav').classList.toggle('active')
})