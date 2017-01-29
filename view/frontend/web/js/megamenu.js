define(['jquery', 'jquery.smartmenus'], function($) {
    var bootstrapMenu = function(config, node) {
        $(config.id).smartmenus({
            subMenusSubOffsetX: 1,
            subMenusSubOffsetY: -8
        });
     };

    return bootstrapMenu;
});
