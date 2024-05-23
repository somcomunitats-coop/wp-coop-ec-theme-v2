/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */

import { useBlockProps } from "@wordpress/block-editor";
import { useEntityProp, store as coreStore } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ context: { postId, postType } }) {
	const [meta] = useEntityProp("postType", postType, "meta", postId);
	const address = meta["ce-address"] || "adreça";

	const [title] = useEntityProp("postType", postType, "title", postId);

	const [excerpt] = useEntityProp(
		"postType",
		"rest-ce-landing",
		"excerpt",
		postId,
	);

	const [featuredImage] = useEntityProp(
		"postType",
		"rest-ce-landing",
		"featured_media",
		postId,
	);

	const { media } = useSelect(
		(select) => {
			const { getMedia } = select(coreStore);

			return { media: getMedia(featuredImage, { context: "view" }) };
		},
		[featuredImage],
	);

	const terms = useSelect((select) => {
		const { getTaxonomy } = select(coreStore);
		return {
			service: getTaxonomy("rest-ce-service"),
			status: getTaxonomy("rest-ce-status"),
		};
	}, []);

	const { services, status } = useSelect(
		(select) => {
			if (!(terms.service && terms.status)) {
				return { services: [], status: null };
			}
			const { getEntityRecords, isResolving } = select(coreStore);

			const getTerms = (term) => {
				const taxonomyArgs = [
					"taxonomy",
					term.slug,
					{
						post: postId,
						per_page: -1,
						context: "view",
					},
				];

				const terms = getEntityRecords(...taxonomyArgs);

				return {
					terms,
					isLoading: isResolving("getEntityRecords", taxonomyArgs),
					has: !!terms?.length,
				};
			};

			return {
				services: getTerms(terms.service),
				status: getTerms(terms.status),
			};
		},
		[postId, terms],
	);

	return (
		<div {...useBlockProps()}>
			<article className="wp-block-group is-style-no-padding has-base-background-color has-background ce-card ce-post-card ce-landing-card">
				<img
					src={media?.source_url}
					className="attachment-post-thumbnail size-post-thumbnail wp-post-image"
				/>
				<div className="taxonomy-rest-ce-status wp-block-post-terms">
					<a href="#" rel="tag" tabindex="0">
						Oberta
					</a>
				</div>
				<div
					style={{ height: "40px" }}
					aria-hidden="true"
					className="wp-block-spacer"
				></div>
				<div className="wp-block-group ce-card-body">
					<div className="wp-block-group ce-card-terms is-layout-flow wp-block-group-is-layout-flow">
						<div className="taxonomy-rest-ce-service wp-block-post-terms">
							<a
								href="https://wordpress.local/rest-ce-service/compres-colectives/"
								rel="tag"
								tabindex="0"
							>
								Compres col·lectives
							</a>
							<span className="wp-block-post-terms__separator"> </span>
							<a
								href="https://wordpress.local/rest-ce-service/eficiencia-energetica/"
								rel="tag"
								tabindex="0"
							>
								Eficiència energètica
							</a>
							<span className="wp-block-post-terms__separator"> </span>
							<a
								href="https://wordpress.local/rest-ce-service/formacio-ciutadana/"
								rel="tag"
								tabindex="0"
							>
								Formació ciutadana
							</a>
						</div>
					</div>
					<div
						style={{ height: "1em", width: "0px" }}
						aria-hidden="true"
						className="wp-block-spacer"
					></div>
					<h4 className="wp-block-heading wp-block-post-title">
						<a tabindex="0" target="_self" href="#">
							{title}
						</a>
					</h4>
					<div className="wp-block-post-excerpt">
						<div className="wp-block-post-excerpt__excerpt">{excerpt}</div>
					</div>
					<hr className="wp-block-separator has-alpha-channel-opacity" />
					<p>{address}</p>

					<p className="wp-block-post-excerpt__more-text">
						<a
							className="wp-block-post-excerpt__more-link"
							href="#"
							tabindex="0"
						>
							Més informació
						</a>
					</p>
				</div>

				<div
					style={{ height: "3rem" }}
					aria-hidden="true"
					className="wp-block-spacer"
				></div>
			</article>
		</div>
	);
}
