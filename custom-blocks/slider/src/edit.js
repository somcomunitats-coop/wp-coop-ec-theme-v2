import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";

export default function Edit({ attributes, setAttributes }) {
  const blockProps = useBlockProps();
  return (
    <div {...blockProps}>
      <InnerBlocks template={TEMPLATE} />
    </div>
  );
}

const TEMPLATE = [["core/group", { layout: { type: "flex", flexWrap: "nowrap" } }, []]];
