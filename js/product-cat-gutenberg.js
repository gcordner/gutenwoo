document.addEventListener("DOMContentLoaded", function () {
    console.log("Gutenberg script loaded");

    const editorDiv = document.getElementById("product-cat-gutenberg-editor");
    const hiddenField = document.getElementById("hidden-description");

    if (!editorDiv || !hiddenField) {
        console.log("❌ Editor div or hidden field not found, exiting...");
        return;
    }

    console.log("Initializing Gutenberg...");

    if (wp && wp.element && wp.blockEditor && wp.data) {
        console.log("✅ Gutenberg dependencies found");

        const { createElement } = wp.element;
        const { render } = wp.element;
        const { RichText } = wp.blockEditor;

        // Inject Gutenberg editor inside the div
        render(
            createElement(RichText, {
                tagName: "p",
                className: "product-cat-description",
                value: hiddenField.value || "",
                onChange: (content) => {
                    console.log("🔄 Updated Content:", content);
                    hiddenField.value = content; // Sync with hidden field
                },
                placeholder: "Enter category description...",
            }),
            editorDiv
        );

        console.log("✅ Gutenberg editor successfully injected into product categories.");
    } else {
        console.error("❌ Gutenberg dependencies not found.");
    }
});
