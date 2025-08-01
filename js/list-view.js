
    document.addEventListener('DOMContentLoaded', function () {
        const savedStateJSON = sessionStorage.getItem('currentPageState');
        let payload;

        if (savedStateJSON) {
            try {
                const savedState = JSON.parse(savedStateJSON);
                payload = {
                    slug: document.body.dataset.slug,
                    ...savedState
                };
            } catch {
                payload = { slug: document.body.dataset.slug, action: 'list' };
            }
        } else {
            payload = { slug: document.body.dataset.slug, action: 'list' };
        }

        loadRoutes(payload);
    });

    function resolveTrigger(trigger) {
        if (!trigger) return null;
        if (trigger instanceof Event) {
            return trigger.currentTarget || trigger.target;
        }
        if (trigger instanceof HTMLElement) {
            return trigger;
        }
        return null;
    }

    // loadRoutes accepts a payload object to send as URLSearchParams
    function loadRoutes(payload) {
        fetch('mvc/base/routes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams(payload)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            document.querySelector('.main').innerHTML = html;
            setUpEventHandlers();
            console.log('DONE');
        })
        .catch(error => {
            console.error('Error fetching routes:', error);
        });
    }

    function getDataByAction(action, trigger = null) {
        const data = {};
        const el = resolveTrigger(trigger);

        if (action === 'edit') {
            if (el?.dataset?.job) data.job = el.dataset.job;
            if (el?.dataset?.suffix) data.suffix = el.dataset.suffix;
        }
        if (action === 'list') {
            if (el?.dataset?.job) data.job = el.dataset.job;
            if (el?.dataset?.suffix) data.suffix = el.dataset.suffix;

            if (el?.dataset?.pageNumber) data.pageNumber = el.dataset.pageNumber;
            if (el?.dataset?.limit) data.limit = el.dataset.limit;

            const productLineSelect = document.querySelector('select[name="filter:product-line"]');
            if (productLineSelect) data.product_line_text = productLineSelect.value;

            const deltaSelect = document.querySelector('select[name="filter:delta"]');
            if (deltaSelect) data.filter_delta = deltaSelect.value;

            const modelInput = document.querySelector('input[name="filter:model"]');
            if (modelInput) data.filter_model = modelInput.value;

            const serialInput = document.querySelector('input[name="filter:serial"]');
            if (serialInput) data.filter_serial = serialInput.value;

            const yearSelect = document.querySelector('select[name="filter:year"]');
            if (yearSelect) data.filter_year = yearSelect.value;

            const monthSelect = document.querySelector('select[name="filter:month"]');
            if (monthSelect) data.filter_month = monthSelect.value;
        }
        return data;
    }

    function buildPayload(trigger = null) {
        const el = resolveTrigger(trigger);
        const meta = document.querySelector('#pageView');
        const slug = document.body.dataset.slug;

        let action = 'list';

        // Determine action from trigger or meta
        if (el?.dataset?.action) {
            action = el.dataset.action;
        } else if (meta?.dataset?.action) {
            action = meta.dataset.action;
        }

        // Start payload with slug and action
        const payload = { slug, action };

        // Collect all data-* attributes from element or meta except 'action' and 'reset'
        const sourceDataset = el?.dataset || meta?.dataset || {};

        for (const [key, value] of Object.entries(sourceDataset)) {
            if (key !== 'action' && key !== 'reset') {
                payload[key] = value;
            }
        }

        // Merge in any additional data based on action (e.g. filters)
        const actionData = getDataByAction(action, el || meta);
        Object.assign(payload, actionData);

        // Handle reset flag
        if (el?.dataset?.reset === '1') {
            payload.reset = 1;
            clearSavedState();
        } else {
            // Save entire current payload as state
            saveCurrentState(action, payload);
        }

        return payload;
    }

    function process(trigger = null) {
        console.log('PROCESS')
        const payload = buildPayload(trigger);
        loadRoutes(payload);
    }

    function setUpEventHandlers() {
        document.querySelectorAll('button[data-page-control="1"]').forEach(button => {
            button.addEventListener('click', event => {
                process(event.currentTarget);
            });
        });

         // For pagination 
        document.querySelectorAll('div[data-pagination="1"][data-active="1"]').forEach(div => {
            div.addEventListener('click', event => {
                process(event.currentTarget);
            });
        });
    }

    // Save current page state to sessionStorage
    function saveCurrentState(action, data) {
        // Store the entire current page state (action + any other data keys)
        const state = { action, ...data };
        sessionStorage.setItem('currentPageState', JSON.stringify(state));
    }

    // Clear saved state
    function clearSavedState() {
        sessionStorage.removeItem('currentPageState');
    }