import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";

export default function save({ attributes }) {
  const { infinite, slidesToShow, slidesToScroll, initialSlide, centerMode } = attributes;

  const blockProps = useBlockProps.save();

  return (
    <div
      {...blockProps}
      infinite={String(infinite)}
      centerMode={String(centerMode)}
      slidesToShow={slidesToShow}
      slidesToScroll={slidesToScroll}
      initialSlide={initialSlide}
    >
      <div class="spinner">Loading</div>
      <InnerBlocks.Content />
    </div>
  );
}
