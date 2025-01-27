const sidebarToggle = document.querySelector('.sidebar-toggle');
const sidebarOverlay = document.getElementById('overlay');
const sidebar = document.querySelector('.sidebar');
const mainContent = document.getElementById('main');
const groups = document.querySelectorAll('.group');
const texts = document.querySelectorAll('.nav-text');
const image = document.getElementById('imagen');
const gym = document.getElementById('gym');
var cont = true;

function ocultarDiv() {
    var div = document.getElementById("loader");
    setTimeout(function() {
      div.classList.add("terminar-loader");
      setTimeout(function() {
        div.style.display="none";
      }, 300);
    }, 10);
}
ocultarDiv();

function closeSidebar() {
    document.getElementById('lista-side').classList.remove("overflow-y-scroll");
    sidebarOverlay.classList.add('hidden');
    sidebar.classList.add('sidebar-contracted');
    sidebar.classList.remove('sidebar-expanded');
    setTimeout(function () {
        mainContent.classList.remove('main-content-expanded');
        mainContent.classList.add('main-content-contracted');
        if (sidebar.classList.contains('sidebar-contracted')) {
            groups.forEach(group => {
                group.classList.remove('selected');
                let submenu = group.querySelector('.submenu');
                let submenu2 = group.querySelector('.ri-arrow-right-s-line');
                if (submenu) {
                    submenu2.classList.add('hidden');
                    submenu.classList.add('hidden');
                }
            });
        }
    }, 100);
    image.classList.add('hidden');
    gym.classList.remove('hidden');
}

function openSidebar() {
    document.getElementById('lista-side').classList.add("overflow-y-scroll");
    sidebar.classList.add('sidebar-expanded');
    sidebar.classList.remove('sidebar-contracted');
    mainContent.classList.add('main-content-expanded');
    mainContent.classList.remove('main-content-contracted');
    sidebarOverlay.classList.remove('hidden');
    image.classList.remove('hidden');
    gym.classList.add('hidden');
}

function toggleSidebar() {
    if (sidebar.classList.contains('sidebar-expanded')) {
        closeSidebar();
    } else {
        openSidebar();
        document.getElementById('lista-side').classList.add("overflow-y-scroll");
    }
}

sidebarToggle.addEventListener('click', function () {
    toggleSidebar();
});

sidebarOverlay.addEventListener('click', function (e) {
    e.preventDefault();
    closeSidebar();
});

function handleResize() {
    if (window.innerWidth >= 768) {
        openSidebar();
    } else {
        closeSidebar();
    }
}

handleResize();

window.addEventListener('resize', handleResize);

// Cargar el estado del grupo seleccionado desde localStorage
document.addEventListener('DOMContentLoaded', function () {
    const selectedGroup = localStorage.getItem('selectedGroup');
    if (selectedGroup) {
        const group = document.getElementById(selectedGroup);
        if (group) {
            group.classList.add('selected');
            const submenu = group.querySelector('.submenu');
            const submenu2 = group.querySelector('.ri-arrow-right-s-line');
            if (submenu) {
                submenu2.classList.remove('hidden');
                submenu.classList.remove('hidden');
            }
        }
    }
});

document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function (item) {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        const parent = item.closest('.group');
        const groupId = parent.id;
        const isSelected = parent.classList.contains('selected');

        if (sidebar.classList.contains('sidebar-expanded')) {
            // Cerrar todos los otros grupos
            groups.forEach(function (group) {
                group.classList.remove('selected');
                let submenu = group.querySelector('.submenu');
                let submenu2 = group.querySelector('.ri-arrow-right-s-line');
                if (submenu) {
                    submenu2.classList.add('hidden');
                    submenu.classList.add('hidden');
                }
            });

            // Alternar el grupo actual
            if (isSelected) {
                parent.classList.remove('selected');
                updateSelectedGroup(null);
            } else {
                parent.classList.add('selected');
                let submenu = parent.querySelector('.submenu');
                let submenu2 = parent.querySelector('.ri-arrow-right-s-line');
                if (submenu) {
                    submenu2.classList.remove('hidden');
                    submenu.classList.remove('hidden');
                }
                updateSelectedGroup(groupId);
            }
        } else {
            parent.classList.remove('selected');
        }
    });
});

function updateSelectedGroup(groupId) {
    if (groupId) {
        localStorage.setItem('selectedGroup', groupId);
    } else {
        localStorage.removeItem('selectedGroup');
    }
}

sidebarToggle.addEventListener('click', function () {
    if (sidebar.classList.contains('sidebar-expanded')) {
        document.querySelectorAll('.group').forEach(function (group) {
            group.classList.add('disable-hover');
        });
    } else {
        document.querySelectorAll('.group.disable-hover').forEach(function (group) {
            group.classList.remove('disable-hover');
        });
    }
});


const popperInstance = {};
document.querySelectorAll('.dropdown').forEach(function (item, index) {
    const popperId = 'popper-' + index;
    const toggle = item.querySelector('.dropdown-toggle');
    const menu = item.querySelector('.dropdown-menu');
    menu.dataset.popperId = popperId;
    popperInstance[popperId] = Popper.createPopper(toggle, menu, {
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
            {
                name: 'preventOverflow',
                options: {
                    padding: 24,
                },
            },
        ],
        placement: 'bottom-end'
    });
});

document.addEventListener('click', function (e) {
    const toggle = e.target.closest('.dropdown-toggle');
    const menu = e.target.closest('.dropdown-menu');
    if (toggle) {
        const menuEl = toggle.closest('.dropdown').querySelector('.dropdown-menu');
        const popperId = menuEl.dataset.popperId;
        if (menuEl.classList.contains('hidden')) {
            hideDropdown();
            menuEl.classList.remove('hidden');
            showPopper(popperId);
        } else {
            menuEl.classList.add('hidden');
            hidePopper(popperId);
        }
    } else if (!menu) {
        hideDropdown();
    }
});

function hideDropdown() {
    document.querySelectorAll('.dropdown-menu').forEach(function (item) {
        item.classList.add('hidden');
    });
}

function showPopper(popperId) {
    popperInstance[popperId].setOptions(function (options) {
        return {
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: true },
            ],
        };
    });
    popperInstance[popperId].update();
}

function hidePopper(popperId) {
    popperInstance[popperId].setOptions(function (options) {
        return {
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: false },
            ],
        };
    });
}

document.querySelectorAll('[data-tab]').forEach(function (item) {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        const tab = item.dataset.tab;
        const page = item.dataset.tabPage;
        const target = document.querySelector('[data-tab-for="' + tab + '"][data-page="' + page + '"]');
        document.querySelectorAll('[data-tab="' + tab + '"]').forEach(function (i) {
            i.classList.remove('active');
        });
        document.querySelectorAll('[data-tab-for="' + tab + '"]').forEach(function (i) {
            i.classList.add('hidden');
        });
        item.classList.add('active');
        target.classList.remove('hidden');
    });
});

function generateNDays(n) {
    const data = [];
    for (let i = 0; i < n; i++) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        data.push(date.toLocaleString('en-US', {
            month: 'short',
            day: 'numeric'
        }));
    }
    return data;
}

function generateRandomData(n) {
    const data = [];
    for (let i = 0; i < n; i++) {
        data.push(Math.round(Math.random() * 10));
    }
    return data;
}

