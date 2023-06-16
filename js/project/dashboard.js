var dashboardListTemplate = Handlebars.compile($('#dashboard_list_template').html());
var Dashboard = {
    run: function () {
        this.router = new this.Router();
        this.listview = new this.listView();
    }
};
Dashboard.Router = Backbone.Router.extend({
    routes: {
        '': 'renderList',
        'dashboard': 'renderList'
    },
    renderList: function () {
        Dashboard.listview.listPage();
    },
    renderListForURLChange: function () {
        history.pushState({}, null, 'main#dashboard');
        Dashboard.listview.listPage();
    }
});
Dashboard.listView = Backbone.View.extend({
    el: 'div#main_container',
    listPage: function () {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        Service.listview.listPage();
        return false;
        Dashboard.router.navigate('dashboard');
        activeLink('menu_dashboard');
        var templateData = {};
        this.$el.html(dashboardListTemplate(templateData));
    },
});
