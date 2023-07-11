import { useBlockProps, InnerBlocks, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, PanelRow, ToggleControl, RangeControl } from "@wordpress/components";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
  const { __ } = wp.i18n;
  const {
    infinite,
    slidesToShow,
    slidesToScroll,
    initialSlide,
    centerMode,
    showArrows,
    showDots,
  } = attributes;
  const blockProps = useBlockProps();

  return (
    <>
      <InspectorControls>
        <PanelBody title={__("Slider settings", "wp-coop-ce-theme")}>
          <PanelRow>
            <RangeControl
              label={__("Number of slides", "wp-coop-ce-theme")}
              value={slidesToShow}
              onChange={(value) => setAttributes({ slidesToShow: value })}
              min={1}
              max={5}
              required
            />
          </PanelRow>
          <PanelRow>
            <RangeControl
              label={__("Slides to scroll", "wp-coop-ce-theme")}
              value={slidesToScroll}
              onChange={(value) => setAttributes({ slidesToScroll: value })}
              min={1}
              max={5}
              required
            />
          </PanelRow>
          <PanelRow>
            <RangeControl
              label={__("Initial slide", "wp-coop-ce-theme")}
              value={initialSlide}
              onChange={(value) => setAttributes({ initialSlide: value })}
              required
            />
          </PanelRow>
          <PanelRow>
            <ToggleControl
              label={__("Infinite slide", "wp-coop-ce-theme")}
              checked={infinite}
              onChange={() => setAttributes({ infinite: !infinite })}
            />
          </PanelRow>
        </PanelBody>
        <PanelBody>
          <PanelRow>
            <ToggleControl
              label={__("Center mode", "wp-coop-ce-theme")}
              checked={centerMode}
              onChange={() => setAttributes({ centerMode: !centerMode })}
            />
          </PanelRow>
        </PanelBody>
        <PanelBody>
          <PanelRow>
            <ToggleControl
              label={__("Show arrows", "wp-coop-ce-theme")}
              checked={showArrows}
              onChange={() => setAttributes({ showArrows: !showArrows })}
            />
          </PanelRow>
        </PanelBody>
        <PanelBody>
          <PanelRow>
            <ToggleControl
              label={__("Show dots", "wp-coop-ce-theme")}
              checked={showDots}
              onChange={() => setAttributes({ showDots: !showDots })}
            />
          </PanelRow>
        </PanelBody>
      </InspectorControls>
      <div {...blockProps} slidesToShow={slidesToShow} centerMode={String(centerMode)}>
        <InnerBlocks template={TEMPLATE} />
      </div>
    </>
  );
}

const TEMPLATE = [
  [
    "core/group",
    {
      className: "ce-block-slider-wrapper",
      layout: {
        type: "flex",
        orientation: "horizontal",
        // flexWrap: "wrap",
      },
      lock: {
        remove: true,
        move: true,
      },
    },
    [],
  ],
];
