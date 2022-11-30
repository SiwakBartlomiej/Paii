document.querySelectorAll('.aDodajDoKoszyka').forEach((elem) => {
    elem.addEventListener('click', async (e) => {
        e.preventDefault()
        const a = e.currentTarget
        const href = a.getAttribute('href')
        const resp = await fetch(href, {method: 'post'})
        const text = await resp.text()

        if (text === 'ok') {
            const ok = document.createElement('i')
            ok.classList.add('fas', 'fa-check-circle', 'text-success')
            a.parentNode.replaceChild(ok, a)
            const lba = parseFloat(document.getElementById("l-ba").innerHTML);
            document.getElementById("l-ba").innerHTML = lba + 1;
        } else {
            alert('Wystąpił błąd')
        }
    })
})