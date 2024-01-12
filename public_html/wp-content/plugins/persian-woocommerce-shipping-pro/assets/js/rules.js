Vue.component('action-hide', {
    props: ['action', 'methods'],
    template: `
        <tr>
        <td>
            <select2 v-model="action.method_id">
                <option value="all">همه روش‌های حمل و نقل</option>
                <template v-for="(method, index) in methods">
                    <option v-bind:value="index">{{ method }}</option>
                </template>
            </select2>
        </td>
        <td>
            مخفی کن
        </td>
        <td>
        </td>
        </tr>`
});

Vue.component('action-show', {
    props: ['action', 'methods'],
    template: `
        <tr>
        <td>
            <select2 v-model="action.method_id">
                <option value="all">همه روش‌های حمل و نقل</option>
                <template v-for="(method, index) in methods">
                    <option v-bind:value="index">{{ method }}</option>
                </template>
            </select2>
        </td>
        <td>
            نمایش بده
        </td>
        <td>
        </td>
        </tr>`
});

Vue.component('action-set-label', {
    props: ['action', 'methods'],
    template: `
        <tr>
        <td>
            <select2 v-model="action.method_id">
                <option value="all">همه روش‌های حمل و نقل</option>
                <template v-for="(method, index) in methods">
                    <option v-bind:value="index">{{ method }}</option>
                </template>
            </select2>
        </td>
        <td>
            عنوان را تعیین کن
        </td>
        <td>
            <input type="text" v-model="action.label">
        </td>
        </tr>`
});

Vue.component('action-add-label', {
    props: ['action', 'methods'],
    template: `
        <tr>
        <td>
            <select2 v-model="action.method_id">
                <option value="all">همه روش‌های حمل و نقل</option>
                <template v-for="(method, index) in methods">
                    <option v-bind:value="index">{{ method }}</option>
                </template>
            </select2>
        </td>
        <td>
            به عنوان اضافه کن
        </td>
        <td>
            <input type="text" v-model="action.label">
        </td>
        </tr>`
});

Vue.component('action-set-cost', {
    props: ['action', 'methods'],
    template: `
        <tr>
        <td>
            <select2 v-model="action.method_id">
                <option value="all">همه روش‌های حمل و نقل</option>
                <template v-for="(method, index) in methods">
                    <option v-bind:value="index">{{ method }}</option>
                </template>
            </select2>
        </td>
        <td>
            هزینه را تعیین کن
        </td>
        <td>
            <input type="text" v-model="action.cost">
        </td>
        </tr>`
});

Vue.component('action-increase-cost', {
    props: ['action', 'methods'],
    template: `
        <tr>
        <td>
            <select2 v-model="action.method_id">
                <option value="all">همه روش‌های حمل و نقل</option>
                <template v-for="(method, index) in methods">
                    <option v-bind:value="index">{{ method }}</option>
                </template>
            </select2>
        </td>
        <td>
            هزینه را افزایش بده
        </td>
        <td>
            <input type="text" v-model="action.cost">
        </td>
        </tr>`
});

Vue.component('action-decrease-cost', {
    props: ['action', 'methods'],
    template: `
        <tr>
        <td>
            <select2 v-model="action.method_id">
                <option value="all">همه روش‌های حمل و نقل</option>
                <template v-for="(method, index) in methods">
                    <option v-bind:value="index">{{ method }}</option>
                </template>
            </select2>
        </td>
        <td>
            هزینه را کاهش بده
        </td>
        <td>
            <input type="text" v-model="action.cost">
        </td>
        </tr>`
});

Vue.component('action-round-cost', {
    props: ['action', 'methods'],
    template: `
        <tr>
        <td>
            <select2 v-model="action.method_id">
                <option value="all">همه روش‌های حمل و نقل</option>
                <template v-for="(method, index) in methods">
                    <option v-bind:value="index">{{ method }}</option>
                </template>
            </select2>
        </td>
        <td>
            هزینه را رند کن
        </td>
        <td>
            <input type="number" v-model="action.cost">
        </td>
        </tr>`
});

const app = new Vue({
    el: '#app',
    data: {
        rules: [],
        rule: null,
        methods: [1, 2],
        conditions: {
            state: {in: [], not_in: []},
            city: {in: [], not_in: []},
            product: {in: [], not_in: []},
            category: {in: [], not_in: []},
            payment: {in: [], not_in: []},
            role: {in: [], not_in: []},
            shipping_class: {in: [], not_in: []},
            week_day: {in: [], not_in: []},
            weight: {min: null, max: null},
            item_qty: {min: null, max: null},
            item_type_qty: {min: null, max: null},
            cost: {min: null, max: null},
            clock: {min: null, max: null},
        }
    },
    methods: {

        addRule: function () {

            this.rule = {
                id: null,
                title: null,
                conditions: JSON.parse(JSON.stringify(this.conditions)),
                actions: [],
                notice_type: '',
                notice_message: ''
            };

        },

        addAction: function (callback) {

            this.rule.actions.push({
                method_id: 'all',
                callback: callback
            })

        },

        RemoveAction: function (index) {
            this.rule.actions.splice(index, 1)
        },

        loadRules: function () {

            let data = {
                action: 'pws_rules_ajax',
                event: 'load_rules'
            }

            jQuery.post(pws_rules.ajax_url, data).then(response => {
                this.rules = response.data;
            });

        },

        loadMethods: function () {

            let data = {
                action: 'pws_rules_ajax',
                event: 'load_methods'
            }

            jQuery.post(pws_rules.ajax_url, data).then(response => {
                this.methods = response.data;
            });

        },

        deleteRule: function (rule_id) {

            if (confirm('آیا مطمئن هستید؟')) {

                let data = {
                    action: 'pws_rules_ajax',
                    event: 'delete_rule',
                    rule_id: rule_id
                }

                jQuery.post(pws_rules.ajax_url, data).then(response => {
                    this.loadRules();
                });

            }

        },

        editRule: function (rule_id) {

            let _rule = this.rules[rule_id];
            _rule.conditions = {...JSON.parse(JSON.stringify(this.conditions)), ..._rule.conditions};

            this.rule = this.rules[rule_id];
        },

        updateRule: function (rule) {
            console.log(JSON.parse(JSON.stringify(rule)));

            if (rule.title == null || rule.title.length < 1) {
                alert('عنوان شرط نمی‌تواند خالی باشد.');

                return;
            }

            if (rule.actions.length < 1) {
                alert('عملیات‌های شرط نمی‌تواند خالی باشد.');

                return;
            }

            let data = {
                action: 'pws_rules_ajax',
                event: 'create_or_update_rule',
                rule: rule
            }

            jQuery.post(pws_rules.ajax_url, data).then(response => {
                this.loadRules();
                alert('شرط با موفقیت ذخیره شد.');

                if (rule.id === null) {
                    this.rule = null;
                }
            });

        }

    },
    created: function () {

        this.loadRules();
        this.loadMethods();

    }
});

