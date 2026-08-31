(function ($) {
    $.fn.filemanager = function (type, options) {
        type = type || "file";

        this.on("click", function (e) {
            var route_prefix =
                options && options.prefix
                    ? options.prefix
                    : "/laravel-filemanager";
            localStorage.setItem("target_input", $(this).data("input"));
            localStorage.setItem("target_preview", $(this).data("preview"));
            window.open(
                route_prefix + "?type=" + type,
                "FileManager",
                "width=900,height=600",
            );
            window.SetUrl = function (url, file_path) {
                var target_input = $(
                    "#" + localStorage.getItem("target_input"),
                );

                var path = file_path.replace("/storage/", "");
                var path = path.replace("/laravel-filemanager", "");
                // var path = path.replace("/laravel-filemanager/images/", "");

                target_input.val(path).trigger("change");

                var target_preview = $(
                    "#" + localStorage.getItem("target_preview"),
                );

                target_preview
                    .attr("src", "/storage/" + path)
                    .trigger("change");
            };
            return false;
        });
    };
})(jQuery);
