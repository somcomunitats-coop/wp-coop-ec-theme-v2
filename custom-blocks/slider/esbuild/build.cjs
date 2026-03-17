const fs = require("fs");
const crypto = require("crypto");
const esbuild = require("esbuild");

(async () => {
  const view = fs.existsSync("src/view.js");
  await esbuild.build({
    entryPoints: view ? ["src/index.js", "src/view.js"] : ["src/index.js"],
    bundle: true,
    minify: true,
    sourcemap: false,
    outdir: "build",
    loader: { ".png": "base64", ".svg": "dataurl" },
    charset: "utf8",
    plugins: [
      {
        name: "clean-dist",
        setup({ onStart }) {
          onStart(() => {
            fs.rmSync("./build", { recursive: true, force: true });
            fs.mkdirSync("./build");
          });
        },
      },
      {
        name: "view-assets",
        setup({ onStart, onEnd }) {
          let hash;

          onStart(() => {
            if (!view) return;
            hash = crypto.createHash("sha1");
            hash.setEncoding("hex");
          });
          onEnd(() => {
            if (!view) return;

            hash.write(fs.readFileSync("./build/view.js", "utf8"));
            hash.end();
            fs.writeFileSync(
              "./build/view.asset.php",
              `<?php return ['dependencies' => [], 'version' => '${hash.read()}'];`,
            );
          });
        },
      },
      {
        name: "index-assets",
        setup({ onStart, onEnd }) {
          let hash;
          onStart(() => {
            hash = crypto.createHash("sha1");
            hash.setEncoding("hex");
          });
          onEnd(() => {
            hash.write(fs.readFileSync("./build/index.js", "utf8"));
            hash.end();
            fs.writeFileSync(
              "./build/index.asset.php",
              `<?php return ['dependencies' => ['react','react-jsx-runtime','wp-api','wp-api-fetch','wp-block-editor','wp-blocks','wp-components','wp-data','wp-element','wp-i18n'], 'version' => '${hash.read()}'];`,
            );
          });
        },
      },
      {
        name: "copy-block-config",
        setup({ onEnd }) {
          onEnd(() => {
            fs.copyFileSync("./src/block.json", "./build/block.json");
          });
        },
      },
      {
        name: "rebuild-log",
        setup({ onStart, onEnd }) {
          var t;
          onStart(() => {
            t = Date.now();
          });
          onEnd(() => {
            console.log("build finished in", Date.now() - t, "ms");
          });
        },
      },
    ],
  });
})();
