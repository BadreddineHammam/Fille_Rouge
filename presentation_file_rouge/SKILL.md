---
name: marp-rapport-presentation
description: Transform a long academic, project, or technical report into a polished 16:9 Marp Markdown presentation. Use when the user provides a report or multiple report sections and wants a complete presentation that preserves the report's structure and evidence.
---

# Marp Presentation from a Report

## Purpose

Convert a report into a concise, professional presentation while preserving:

- the report's project name and real facts;
- the original section order;
- methodology, architecture, diagrams, screenshots, and conclusions;
- the user's preferred language and formatting.

Produce a Marp-compatible Markdown file with a clean 16:9 layout, useful imagery, and no invented content.

## Required inputs

Ask for or locate:

1. the report source (`.md`, `.txt`, `.pdf`, or a folder of report files);
2. the target presentation path;
3. the project title and presenter details;
4. institution and encadrant/supervisor details;
5. logos and other images/diagrams;
6. the preferred language.

Reasonable defaults may be used when the information is not critical. Do not invent names, technologies, dates, results, or screenshots.

## Workflow

1. **Inventory the report**
   - Read headings, tables, diagrams, figures, and source files.
   - List available assets and their relative paths.
   - Identify facts that must appear exactly as written.

2. **Build a slide map**
   - Keep major report sections as presentation sections.
   - Choose one main idea per slide.
   - Avoid placing a full report chapter on one slide.
   - Convert dense paragraphs into short bullets or presenter notes.

3. **Create or update the presentation**
   - Start with the Marp frontmatter and reusable CSS.
   - Add a title slide.
   - Follow with the report sections in a logical order.
   - Add section breaks only when they improve navigation.
   - Use image and diagram slides when the visual carries the information.

4. **Validate**
   - Check that every source heading is represented or intentionally excluded.
   - Check all image paths from the presentation directory.
   - Check Marp separators and frontmatter.
   - Check that slides fit: roughly 4-7 bullets or one diagram per slide.
   - Preview or render it if a Marp tool is available.
   - Report unresolved missing assets instead of creating fake placeholders.

## Default design

Unless the user provides a template or existing presentation:

- format: `16:9`;
- theme: `default`;
- pagination: enabled;
- light background: `#f8fafc`;
- primary text: `#172033`;
- heading blue: `#243b6b`;
- font: `Aptos`, fallback `Segoe UI`, sans-serif;
- title size: about `2.4em`;
- heading size: about `1.8em`;
- body/bullet size: about `1.25em`;
- slide padding: `48px 64px`;
- image-only and diagram slides use dedicated Marp classes.

## Slide rules

- Use title-level headings only for the title slide.
- Use one `##` heading per regular slide.
- Separate slides with `---`.
- Keep title slides visually sparse.
- Prefer bullets to full paragraphs.
- Use short bullet fragments, not lengthy academic prose.
- Limit each bullet to one idea.
- Put detailed content in the report or presenter notes.
- Add source titles as figure captions when useful.
- Do not duplicate long lists across several slides unless they must be spoken in sequence.
- Never repeat information from the same report in several slides without a clear purpose.

## Classes

Use these Marp classes consistently:

```markdown
<!-- _class: title-slide -->
```

For a centered title and logo row.

```markdown
<!-- _class: image-only -->
```

For a diagram or screenshot that should fill the slide.

```markdown
<!-- _class: diagram-slide -->
```

For UML, architecture, and technical diagrams.

If the existing presentation already defines custom classes, reuse them before creating new ones.

## Frontmatter template

```markdown
---
marp: true
theme: default
size: 16:9
paginate: true
style: |
  section {
    font-family: "Aptos", "Segoe UI", sans-serif;
    background: #f8fafc;
    color: #172033;
    padding: 48px 64px;
  }
  h1, h2 {
    color: #243b6b;
  }
  h1 {
    font-size: 2.4em;
  }
  h2 {
    font-size: 1.8em;
    margin-bottom: 0.7em;
  }
  ul {
    font-size: 1.25em;
    line-height: 1.65;
  }
  section.title-slide {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
  }
  section.image-only,
  section.diagram-slide {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  section.image-only img,
  section.diagram-slide img {
    max-width: 96%;
    max-height: 78%;
    object-fit: contain;
  }
---
```

## Slide patterns

### Title

```markdown
<!-- _class: title-slide -->

# Project title

<div class="brand-row">
  <img src="institution.png" alt="Institution logo" />
  <img src="school.png" alt="School logo" />
</div>

Presenter name  
Supervisor: Supervisor name

---
```

### Overview

```markdown
## Project overview

- Problem addressed
- Main user need
- Proposed solution
- Main result

---
```

### Diagram

```markdown
<!-- _class: diagram-slide -->

## System architecture

![Architecture diagram](assets/architecture.png)

*Figure: Description of the architecture.*

---
```

### Thank-you slide

```markdown
<!-- _class: title-slide -->

# Conclusion

## Merci pour votre attention

Questions

---
```

## Long-report strategy

For a report with many sections:

1. Extract a 12-18 slide core.
2. Group related subsections under major headings.
3. Reserve 1-3 slides for essential diagrams.
4. Compress implementation details without removing project value.
5. Use appendices or extra slides only if requested.

Suggested structure:

- title;
- thanks;
- introduction/context;
- problem and objectives;
- methodology;
- planning;
- functional analysis;
- technical analysis and architecture;
- design and models;
- implementation and interfaces;
- results and tests;
- conclusion.

Adapt the structure to the report. Do not add methodology or technology sections that are not present.

## Faithfulness rules

- Never attribute a claim to a team or source if the report does not state it.
- Never replace unknown data with likely-looking values.
- Keep technical names exactly as written.
- Preserve accent characters and the report language.
- Use the report's project name consistently.
- If a required asset is missing, leave a clear comment and tell the user:

```markdown
<!-- TODO: Add institution logo: institution.png -->
```

Do not silently substitute unrelated images or stock illustrations.

## Images

- Resolve paths relative to the presentation Markdown file.
- Prefer existing project assets and diagrams.
- When copying assets, keep descriptive names and update all Markdown paths.
- Never use remote image URLs unless the user approves them.
- Set alt text that describes the image.
- Use `width="..."` or CSS classes only when an image needs explicit sizing.

## Presenter's notes

Use Marp comments for optional speaker notes only when requested or useful:
Use the marp-rapport-presentation skill.
Create presentation.md from the attached rapport folder.
Follow the existing 16:9 blue-and-white presentation style.
Do not invent missing information.
```markdown
<!--
Presenter note:
- Explain the problem in 30 seconds.
- Transition to the architecture diagram.
-->
```
