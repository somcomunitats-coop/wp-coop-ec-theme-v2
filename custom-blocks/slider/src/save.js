import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";

export default function save({ attributes }) {
  const blockProps = useBlockProps.save();

  return (
    <div {...blockProps} class="loading">
      <InnerBlocks.Content />
    </div>
  );
}
