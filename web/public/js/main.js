function addNotification(title, text, svgType) {

    if ($("#notifications-container").length === 0) {
        $('body').append('<div id="notifications-container" class="fixed top-0 right-0 z-[9999] flex flex-col space-y-4 p-4"></div>');
    }       

    let svgIcon = "";

    if(svgType == "Success") {
        svgIcon = `<svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> </svg>`
    } else if(svgType == "Danger") {
        svgIcon = `<svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"> <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path> </svg>`
    } else if(svgType == "Information") {
        svgIcon = `<svg class="h-6 w-6 text-sky-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"> <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path> </svg>`
    }

    const notification = `
    <div aria-live="assertive" class="pointer-events-none w-80 mb-2 new-notification z-[9999]">
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
            <div class="transform ease-out duration-300 transition pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2 new-notification-panel">
            <div class="p-4">
                <div class="flex items-start">
                <div class="flex-shrink-0">${svgIcon}</div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900 font-onest">${title}</p>
                    <p class="mt-1 text-sm text-gray-500 font-onest">${text}</p>
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#8d46f6] focus:ring-offset-2 close-btn">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    </button>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>`;

    $("#notifications-container").append(notification);
    setTimeout(() => {
        $(".new-notification-panel").removeClass("translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2").addClass("translate-y-0 opacity-100 sm:translate-x-0");
    }, 100);
    setTimeout(() => {
        closeNotification();
    }, 10000);
}

function closeNotification() {
    const notification = $(".new-notification:last");
    const notificationPanel = $(".new-notification-panel:last");
    notificationPanel.removeClass("transform ease-out duration-300").addClass("transition ease-in duration-100")
    setTimeout(() => {
        notificationPanel.removeClass("opacity-100").addClass("opacity-0")
    }, 100);
    setTimeout(() => {
        notification.remove();
    }, 300);
}

$(document).on("click", ".close-btn", function() {
    closeNotification();
});

function appendDivWithScript(scriptContent) {
    const randomClass = getRandomClass();
    const $div = $("<div>", { class: randomClass + ' hidden' });

    $div.html(scriptContent);
    $('body').append($div);

    setTimeout(() => {
        $div.remove();
    }, 10000);
}

function getRandomClass() {
    return 'randomClass-' + Math.floor(Math.random() * 1000000);
}


$(document).ready(function() {
    initModalEventHandlers();
    observeMutations();
});

function openModal(modalSelector) {
    $(modalSelector).removeClass('opacity-0').removeClass('hidden').addClass('opacity-100');
    $('body').addClass('overflow-y-hidden');
}

function closeModal(modalSelector) {
    $(modalSelector).removeClass('opacity-100').addClass('opacity-0');
    setTimeout(() => {
        $(modalSelector).addClass('hidden');
        $('body').removeClass('overflow-y-hidden');
    }, 200);
}

function initModalEventHandlers() {
    $(document).on('click', '.open-modal-button', function() {
        const modalSelector = $(this).attr('data-modal-target');
        openModal(modalSelector);
    });

    $(document).on('click', '.modal-close-button', function() {
        const modalSelector = $(this).closest('.modal').attr('id');
        closeModal('#' + modalSelector);
    });

    $(document).on('click', '.modal', function(event) {
        if ($(event.target).hasClass('modal')) {
            closeModal('#' + $(this).attr('id'));
        }
    });

    $(document).on('click', '.modal-content', function(event) {
        event.stopPropagation();
    });
}


function observeMutations() {
    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            if (mutation.addedNodes.length || mutation.removedNodes.length) {
                initModalEventHandlers();
            }
        });
    });

    const config = {
        childList: true,
        subtree: true,
    };

    const targetNode = document.querySelector('.mutation-area');
    if (targetNode) {
        observer.observe(targetNode, config);
    }
}