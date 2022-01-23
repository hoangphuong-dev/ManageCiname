import confirm from "./confirm";
import image from "./image";

export default function(app) {
    app.mixin(confirm);
    app.mixin(image);
}
