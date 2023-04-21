let statistics = document.getElementById('statistics')
let tools = document.getElementById('tools')

document.addEventListener('click', e => {
    if (statistics.contains(e.target) && !statistics.classList.contains('enabled')) statistics.classList.add('enabled')
    else statistics.classList.remove('enabled')

    if (tools.contains(e.target) && !tools.classList.contains('enabled')) tools.classList.add('enabled')
    else tools.classList.remove('enabled')
})