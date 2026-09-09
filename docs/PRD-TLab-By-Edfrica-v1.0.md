# TLAB BY EDFRICA — Website & Learning Platform

## Product Requirements Document

- **Version:** 1.0
- **Prepared for:** TLab by Edfrica
- **Primary audience:** Product owner, UI/UX designer, frontend developer, backend developer, QA
- **Date:** 8 September 2026
- **Status:** Build-ready scope; commercial prices and final brand assets remain owner inputs

### Build decision

Phase 1 is a focused TLab operations and learning portal. It must sell programmes, enrol learners, run classes, manage attendance, accept two forms of assignment submission, support marking and feedback, show parent progress, and give the Super Admin complete oversight. Native video, CBT, school self-service, white-labelling, and curriculum licensing are deliberately deferred.

---

## Document control and how to use this PRD

This document is the single product reference for the redesign. When a screen, workflow, or feature is not described here, the team should not silently invent it. Raise a product decision, document it, and obtain approval before adding scope.

| Item | Decision |
|---|---|
| Product name | TLab by Edfrica |
| Primary Phase 1 users | Visitors, parents/guardians, students, facilitators, staff administrators, Super Admin |
| Primary Phase 1 channels | Hub/after-school membership, Saturday membership, virtual cohorts, manually managed school cohorts |
| Phase 2 expansion | School portal, school administrator, CBT, school reporting, tenancy-ready architecture |
| Phase 3 expansion | Curriculum licensing, teacher delivery, kits, subscription billing, white-label configuration |
| Phase 4 expansion | Scaled multi-tenant TLab School STEM System and integrations |

---

## Contents

1. Executive product decision
2. Current website diagnosis
3. Product goals, measures and boundaries
4. Information architecture and public website specification
5. Phase 1 roles and permissions
6. Phase 1 learning portal requirements
7. Assignment, marking and project workflow
8. Class delivery and attendance
9. Parent, student, facilitator and admin dashboards
10. Backend, data and integrations
11. Security, privacy and child safeguarding
12. Notifications, reporting and analytics
13. UX and design system
14. Delivery plan and acceptance criteria
15. Phase 2–4 product roadmap
16. Migration, content and launch checklist
- Appendices

---

## 1. Executive product decision

### 1.1 What the team is building

The product has two connected surfaces:

- **Marketing website:** explains TLab, proves credibility, helps parents find the correct pathway, captures school enquiries, and converts visitors into trial bookings or enrolments.
- **Learning and operations portal:** manages learners, guardians, programmes, cohorts, schedules, live-class access, attendance, assignments, marking, feedback, progress, payments, certificates, and administrative reporting.

**Non-negotiable principle:** The website sells TLab. The portal runs TLab. They may share branding and authentication, but their jobs, navigation and success measures are different.

### 1.2 Positioning to implement

- **Primary line:** Where young people learn to build with technology.
- **Supporting line:** Practical STEM, coding, robotics and future-skills programmes for children ages 5–17, delivered at our learning hub, online and in schools.
- **Primary audience split:** For Parents and For Schools. Every major public page must make the next action obvious for one of these audiences.

### 1.3 Phase 1 operating model

| Channel | Commercial model | Learning structure | System treatment |
|---|---|---|---|
| Saturday / after-school hub | Monthly payment with term commitment | One fixed weekly class; 10–12 week cycle | Membership enrolment tied to a cohort |
| Virtual | Fixed course fee; full or two instalments | 8-week live cohort; weekly class | Course purchase tied to cohort dates |
| Schools in Phase 1 | Contract/term fee managed by TLab staff | 10–12 week school cohort | Admin-created organisation and classes; no school self-service yet |
| Holiday lab | One-off programme fee | 1–3 week intensive | Short cohort with start/end dates |

---

## 2. Current website diagnosis

The existing website should not receive a cosmetic reskin. Its public structure and product logic conflict with the intended business model. The redesign must first correct the following.

| Current issue | Why it damages the business | Required correction |
|---|---|---|
| Competing structures: four clubs, five growth lines, and 16+ courses | Parents must decode TLab before they can buy; internal curriculum categories are exposed as products. | Replace with three age pathways and four delivery formats. |
| Age range varies between 3–15 and 3–18 | Creates doubt about programme readiness and safeguarding. | Use ages 5–17 unless a separate early-years product is approved. |
| "Africa's leading/#1" and "500+ active" claims | Unverified superlatives weaken trust and create substantiation risk. | Use accurate, evidence-backed reach and outcome statements only. |
| Pricing and schedule contradictions | Different session durations/frequencies and incorrect discount calculations create purchase friction. | Use one canonical programme/price record in the database; render every page from it. |
| Adult Techiecity courses mixed with children's membership | Dilutes TLab and confuses the intended buyer. | Move adult/professional offerings to Edfrica or a separate site. |
| Gamification leads the proposition | XP and ranks appear more important than learning outcomes. | Lead with projects, progression and parent-visible evidence; retain light gamification. |
| Compliance claims presented as marketing | A claim of full compliance is unsafe without verified controls. | Use factual privacy language reviewed against actual system behaviour. |

*Source snapshot reviewed 8 September 2026: tlab.edfrica.org home, membership and login pages. See Appendix F.*

---

## 3. Product goals, measures and boundaries

### 3.1 Phase 1 goals

- Make the correct programme understandable within 60 seconds.
- Allow a parent to submit an enrolment or trial request without staff retyping the same data.
- Give facilitators one daily workflow: open class, review lesson, take attendance, publish assignment, mark work, record feedback.
- Give students one learning home for schedule, class access, resources, assignments, submissions, results and certificates.
- Give parents evidence of attendance, work completed, feedback, progress and payment status.
- Give the Super Admin full operational visibility, permissions control, correction tools, exports and audit logs.

### 3.2 Success metrics

| Area | Metric | Initial target after 90 days |
|---|---|---|
| Acquisition | Programme-page visitor → enquiry/trial conversion | Baseline in month 1; improve by at least 20% by month 3 |
| Operations | Paid/approved learners correctly assigned before first class | ≥ 98% |
| Teaching | Scheduled sessions with attendance recorded within 24 hours | ≥ 95% |
| Assignments | Submitted work marked within agreed service level | ≥ 90% within 72 hours |
| Parent value | Active parents opening progress update monthly | ≥ 60% |
| Reliability | Successful login and critical workflow availability | ≥ 99.5% monthly, excluding planned maintenance |
| Support | Critical child-access/payment issues resolved | Same working day |

### 3.3 Explicit Phase 1 exclusions

- Native video conferencing or streaming
- Open marketplace of self-paced courses
- AI-generated marking
- Public student leaderboards
- Full school self-service administration
- CBT examination engine
- White-label domains/themes
- Complex SCORM/xAPI authoring
- Parent-to-child or student-to-student chat
- Mobile applications; responsive web is sufficient
- Automated timetable optimisation

---

## 4. Information architecture and public website specification

### 4.1 Main navigation

| Navigation item | Destinations / purpose |
|---|---|
| Programmes | Hub & Saturday, After-School, Online, Holiday Labs |
| Learning Pathways | Little Explorers 5–7, Junior Innovators 8–11, Tech Builders 12–17 |
| For Schools | Managed programme, benefits, delivery process, partnership enquiry |
| Projects & Impact | Student work, showcases, verified reach, testimonials and case studies |
| About | Story, approach, safeguarding, team/facilitators, contact |
| Pricing | Current parent-facing programmes only; prices from one backend source |
| Login | Role-aware login to the portal |
| Primary CTA | Book a Trial / Enrol; wording can vary by programme availability |

### 4.2 Public URL map

- /
- /programmes
- /programmes/hub
- /programmes/online
- /programmes/holiday-labs
- /pathways/little-explorers
- /pathways/junior-innovators
- /pathways/tech-builders
- /schools
- /projects
- /about
- /pricing
- /faq
- /contact
- /enrol
- /book-trial
- /privacy
- /terms
- /safeguarding
- /login

### 4.3 Homepage sections in required order

1. **Hero:** positioning, ages 5–17, delivery modes, "Find a Programme" and "Partner With TLab" calls to action.
2. **Trust strip:** verified learner reach, programmes completed, school partners, location and safeguarding statement. Hide any metric that cannot be proved.
3. **Choose how your child learns:** Hub/Saturday, Online, Holiday Labs, Schools.
4. **Choose the correct age pathway:** three cards with age, outcome and sample project.
5. **How learning works:** learn, build, present, progress.
6. **Real student projects:** image/video, learner first name or approved alias, age, project, skill and consent status.
7. **Parent/school proof:** short verified testimonials or partner logos with permission.
8. **Upcoming cohorts:** only open or waitlist-enabled cohorts pulled from the backend.
9. **School partnership block:** outcome, delivery model, request-assessment CTA.
10. **FAQ and final CTA.**

### 4.4 Programme page template

- Clear name, delivery mode, age range and one-sentence outcome.
- What the learner will build; use 3–5 specific examples.
- Skills/modules, level/prerequisites and equipment required.
- Schedule, duration, location or online format, cohort size and available seats.
- Price, registration fee, instalment terms, refund/rescheduling summary and what is included.
- Facilitator summary and safeguarding information.
- What parents receive: progress updates, report, certificate and showcase.
- Primary CTA with cohort selection; alternative waitlist CTA when full.
- FAQ specific to that programme.

### 4.5 Enrolment and trial forms

Do not request a child's full profile before the parent understands the offer. Use progressive disclosure.

| Step | Required fields | System result |
|---|---|---|
| 1. Programme interest | Programme/cohort, learning mode, child age band | Validates availability and eligibility |
| 2. Guardian | Full name, email, phone/WhatsApp, relationship | Creates or matches guardian record |
| 3. Child | Preferred/full name, date of birth, school/grade optional, learning needs/allergies where necessary | Creates pending child profile under guardian |
| 4. Consent | Terms, privacy notice, photography choice, emergency contact where physical | Stores versioned consent record |
| 5. Payment/approval | Pay now, bank transfer pending verification, or staff-approved trial | Creates application/enrolment status |
| 6. Confirmation | Receipt/status, next step, account activation | Sends confirmation and creates admin task if manual action is required |

### 4.6 Content management requirements

Administrators must update content without a developer for routine changes. Use structured content fields, not free-form page builders for critical commercial data.

- Programmes and pathways
- Cohorts, dates, capacity and waitlist state
- Pricing and discounts
- Facilitator bios
- FAQs
- Testimonials and partner logos
- Projects and impact stories
- Homepage announcements
- Policies and consent versions

---

## 5. Phase 1 roles and permissions

### 5.1 Roles

| Role | Meaning |
|---|---|
| Super Admin | Highest-authority TLab owner. Sees all records and audit history; manages settings, staff roles, access and corrections. |
| Administrator | Operational staff. Manages users, enrolments, cohorts, schedules, payments, content and reports according to assigned permissions. |
| Facilitator | Sees only assigned cohorts and learners; delivers classes, attendance, assignments, marking and learner feedback. |
| Parent/Guardian | Owns the family account; manages linked children, consents, payments, schedules, reports and support requests. |
| Student | Accesses only their learning experience, using parent-managed credentials for minors. |
| Read-only reviewer | Optional internal role for management/quality assurance; cannot alter records. |

### 5.2 Permission matrix

| Capability | Super Admin | Admin | Facilitator | Parent | Student |
|---|---|---|---|---|---|
| View all users/cohorts | Yes | By permission | Assigned only | Own family | Self |
| Create/edit programmes | Yes | By permission | No | No | No |
| Assign facilitator | Yes | Yes | No | No | No |
| View child sensitive notes | Yes | Limited role | Only teaching-relevant | Own child | No |
| Take/edit attendance | Yes | Yes | Assigned cohort | View | View own |
| Create assignments | Yes | Yes | Assigned cohort | View | View |
| Submit assignment | Override | No | No | No | Own only |
| Mark/return assignment | Yes | QA/override | Assigned cohort | View result | View result |
| Manage payments/refunds | Yes | Finance permission | No | Own payments | No |
| Export data | Yes | By permission | Assigned class only | Own reports | Own certificate |
| Manage roles/settings/audit | Yes | No | No | No | No |

### 5.3 Super Admin "sees everything" requirement

"Everything" must mean complete authorised operational visibility, not unsafe unrestricted access. The Super Admin dashboard must provide:

- Global totals and filters across branches, programmes, cohorts, schools, facilitators, learners, attendance, assignments, submissions, payments and certificates.
- User search with account status, linked roles, last login, enrolments and support flags.
- Role and permission management, including forced logout, suspend/reactivate, password reset trigger and two-factor enforcement for staff.
- Operational corrections: move learner between cohorts, reopen submission, correct attendance, reassign facilitator, record manual payment and regenerate certificate.
- Audit log showing actor, action, target, timestamp, prior value, new value and IP/device metadata where appropriate.
- Impersonation only if implemented with a visible "viewing as" banner, time limit, reason field and immutable audit record. Direct password access is forbidden.
- CSV/XLSX exports with permission checks and export logs.
- System configuration for terms, grading scales, notification templates, supported file types, maximum sizes and consent versions.

---

## 6. Phase 1 learning portal requirements

### 6.1 Shared portal shell

After login, route users to the correct dashboard. If one adult has more than one role, provide a role switcher. The left navigation must change by role; do not show disabled menus that the role can never use.

| Shared feature | Required behaviour |
|---|---|
| Authentication | Email/password plus reset; optional social/Edfrica identity only if stable. Staff 2FA required. |
| Notifications | In-app notification centre plus email; WhatsApp/SMS only for approved transactional events. |
| Calendar | List and calendar views; timezone-aware; add-to-calendar link. |
| Search | Role-filtered search for classes, assignments, learners and programmes. |
| Help | Contextual help and support ticket/contact route. |
| Profile | Name, contact, avatar optional, password/security, notification preferences. |
| Accessibility | Keyboard access, clear focus state, labelled controls, readable contrast, responsive layout. |

### 6.2 Programme, cohort and class hierarchy

Use these terms consistently:

- **Pathway:** age-based long-term learning journey, e.g., Junior Innovators.
- **Programme:** sellable learning offer, e.g., Saturday STEM Membership or 8-Week Scratch Level 1.
- **Module:** curriculum unit within a programme, e.g., Loops and Conditions.
- **Cohort:** specific group with dates, capacity, facilitator and schedule.
- **Session:** one scheduled class occurrence.
- **Lesson:** teaching plan/resources attached to a session or module.
- **Assignment:** required or optional work with deadline and marking rule.
- **Project:** evidence-of-learning artifact; it may be created from an assignment but can also be uploaded by staff after a physical build.

### 6.3 Canonical statuses

| Object | Allowed statuses |
|---|---|
| Programme | Draft, Published, Archived |
| Cohort | Draft, Open, Full, In Progress, Completed, Cancelled |
| Enrolment | Enquiry, Trial Booked, Pending Payment, Pending Review, Active, Paused, Completed, Withdrawn, Cancelled |
| Session | Scheduled, Live, Completed, Cancelled, Rescheduled |
| Attendance | Present, Late, Absent, Excused, Not Recorded |
| Assignment | Draft, Published, Closed, Archived |
| Submission | Not Started, Draft, Submitted, Late, Returned for Revision, Resubmitted, Marked |
| Payment | Pending, Successful, Failed, Partially Paid, Refunded, Waived, Manually Verified |

---

## 7. Assignment, marking and project workflow

**Approved Phase 1 decision:** Give students exactly two submission methods inside one assignment system: (1) upload a file, or (2) submit a project link with an optional short note. The facilitator selects one method or allows both when creating the assignment.

### 7.1 Submission method A: file upload

- Accept approved formats only: PDF, DOCX, PPTX, XLSX, JPG, PNG and ZIP. Add MP4 only when storage and upload limits are deliberately funded.
- Default maximum: 25 MB per file and 3 files per submission; both values configurable.
- Show filename, size, upload progress, success state and remove/replace option before submission.
- Store files privately; access requires a short-lived authorised URL.
- Run malware/type validation and never trust the filename extension alone.
- Preserve previous versions after resubmission; show version history to facilitator and administrator.

### 7.2 Submission method B: project link

- Accept a URL plus optional 500-character explanation. Typical links: Scratch project, Replit, GitHub, Google Drive, Figma or published website.
- Validate URL format, but do not claim the link is publicly accessible until checked.
- Show students a reminder to set sharing permissions correctly.
- Facilitator can mark a broken/private link as "Returned for Revision" with a reason.
- Allow an optional thumbnail or screenshot only if the assignment also permits file upload.

### 7.3 Facilitator creates an assignment

1. Open assigned cohort and choose Assignments → New Assignment.
2. Enter title, learner instructions, linked module/session, learning outcomes and due date/time.
3. Choose individual or group assignment; group work is optional for Phase 1 and may be disabled.
4. Choose accepted submission method: file, link, or either.
5. Choose marking mode: points, rubric, complete/incomplete, or feedback-only. Phase 1 should default to rubric or complete/incomplete for younger learners.
6. Attach resources and preview the student view.
7. Save draft or publish now/schedule publication.
8. System notifies active enrolled learners and linked parents according to preferences.

### 7.4 Student submits work

1. Student opens assignment from dashboard or class page.
2. System displays instructions, deadline, submission type, resources and current status.
3. Student uploads file(s) or pastes project link and note.
4. Student saves draft or presses Submit. Submission requires confirmation.
5. System records timestamp, marks late automatically when applicable, locks accidental edits, and sends receipt.
6. Student may replace before deadline if the facilitator enabled resubmission. Every submitted version remains auditable.

### 7.5 Facilitator marks work

1. Open cohort → assignment → submissions queue.
2. Filter by not submitted, submitted, late, revision requested and marked.
3. Open learner work in a safe preview or authorised download; external links open in a new tab.
4. Apply rubric/score or completion status, write feedback and optionally attach an annotated file.
5. Choose Save Draft, Return for Revision, or Publish Result.
6. Publishing updates the student and parent dashboards. Private facilitator notes remain staff-only.
7. Admin/Super Admin can moderate, override or reopen a grade; the audit log must preserve both values.

### 7.6 Marking rules

| Rule | Requirement |
|---|---|
| Default service level | Mark within 72 hours unless programme policy states otherwise. |
| Late work | Accept and label late by default; facilitator can close submissions or grant learner-specific extension. |
| Revision | A returned submission must include actionable feedback and a new deadline if required. |
| Visibility | Scores/feedback stay hidden until Publish Result; no accidental partial release. |
| Rubrics | Reusable by programme/age band; criteria and levels editable only by authorised staff. |
| Younger learners | Facilitator or admin may upload photo/evidence on behalf of the learner; action is labelled staff-uploaded. |

---

## 8. Class delivery and attendance

### 8.1 Where the class happens

Do not build native video in Phase 1. It is expensive, difficult to moderate, and adds reliability problems that do not improve the curriculum. Use an external provider while the TLab portal remains the control centre.

| Class type | Delivery location | Portal responsibility |
|---|---|---|
| Physical hub / after-school | TLab location | Room, date/time, facilitator, roster, attendance, lesson resources and follow-up. |
| Virtual live class | Google Meet or Zoom link | Securely expose join link to active learners shortly before class; show timezone, start time, materials and attendance. |
| School cohort | School room or school-approved online link | School/location, class label, facilitator, roster, attendance and lesson record. |

### 8.2 Class page

- Session title, date, start/end time, timezone and status.
- Join Class button for virtual sessions; visible only to authorised active enrolments within a configurable time window.
- Location/map instructions for physical classes.
- What to bring and preparation checklist.
- Lesson objectives and student-safe resources.
- Assignment due after class.
- Attendance state and facilitator summary after class.
- Recording link only when consent, storage, access and retention rules have been approved.

### 8.3 Facilitator's "run class" mode

1. Open Today's Class.
2. Review lesson plan and materials.
3. Start attendance and mark every learner; unmarked remains visible as an error.
4. Record short session note, curriculum coverage and issues.
5. Attach project photo/evidence only for learners with suitable consent.
6. Publish or schedule assignment.
7. Complete session. System triggers absent-learner and parent updates according to policy.

### 8.4 Attendance controls

- Facilitator can record attendance only for assigned cohorts and scheduled sessions.
- Changes after 24 hours require a reason and appear in the audit log.
- Bulk mark Present is allowed, but facilitator must confirm exceptions.
- Admins can export by learner, cohort, programme, facilitator, location and date range.
- Automated alerts should begin only after TLab defines the rule, e.g., two consecutive absences. Do not hard-code it.

---

## 9. Dashboard specifications

### 9.1 Student dashboard

| Priority | Widget / screen | What it must do |
|---|---|---|
| P0 | Next class | Date/time, location or join button, preparation, countdown only when useful. |
| P0 | My assignments | Due soon, submitted, revision required, marked; direct action. |
| P0 | My learning | Current pathway, programme, cohort, module and progress. |
| P0 | Resources | Role-safe lesson files/links organised by module. |
| P0 | My projects | Portfolio of submitted or staff-approved evidence. |
| P1 | Feedback/results | Published facilitator feedback and rubric/score. |
| P1 | Certificates | View/download verified certificates. |
| P2 | Badges | Small set tied to meaningful milestones; no public ranking. |

### 9.2 Parent dashboard

- Child switcher for multiple linked children.
- Current programme, cohort, status and next class.
- Attendance history and absence notes.
- Upcoming/overdue assignments and published results.
- Progress summary by skill/module, facilitator comment and term report.
- Payments, balance, instalment due dates, receipts and renewal action.
- Consent and child profile management.
- Certificates and approved project portfolio.
- Support/contact route; no direct unmoderated chat with facilitators.

### 9.3 Facilitator dashboard

- Today/this week schedule.
- Assigned cohorts and learner rosters.
- One-click Run Class.
- Attendance requiring completion.
- Assignments in draft and marking queue.
- Learners needing attention: repeated absence, overdue revision or missing submission. Avoid automated labels that imply diagnosis.
- Lesson plans/resources for assigned programme.
- Feedback history and reports due.
- Announcements from administrators.

### 9.4 Administrator dashboard

- Enquiries, trials, pending payments and enrolments needing action.
- Cohort occupancy, start dates, timetable clashes and facilitator assignment.
- Attendance completion and assignment marking SLA.
- Payment collection, overdue instalments, manual verification queue and refunds.
- Programme/content management and announcements.
- Reports and exports within permission scope.
- Support cases and data-correction queue.

### 9.5 Super Admin command centre

| Panel | Minimum display |
|---|---|
| Operations today | Sessions scheduled/completed/cancelled; attendance pending; facilitators active. |
| Learners | Active, new, paused, completed, at-risk by defined operational rule. |
| Commercial | Revenue collected, pending, failed, refunded; enrolment conversion; renewals due. |
| Learning | Assignments published/submitted/marked; marking turnaround; module completion. |
| Schools | Phase 1 school cohorts, learners, sessions, attendance and contract dates. |
| System | Failed notifications, failed payment callbacks, storage use, security events and audit log. |

---

## 10. Backend, data and integrations

### 10.1 Architecture decision

**Recommended technical shape:** Build a modular monolith with a relational database, private object storage, background jobs and a documented API boundary. A microservice architecture in Phase 1 would be needless complexity. Design school ownership/tenant fields into the schema now, but do not expose a full multi-tenant product yet.

The current framework may be retained only if it is maintainable, documented, testable and supports server-side authorisation. If the existing codebase cannot meet those conditions, rebuild the application layer while preserving approved assets and data.

### 10.2 Suggested components

| Layer | Recommendation | Reason |
|---|---|---|
| Frontend | Responsive web application; Next.js/React or the team's proven equivalent | Good public SEO plus authenticated portal; one maintainable web surface. |
| Backend | Typed server application with modular domains and REST/GraphQL endpoints | Clear business rules and auditable access control. |
| Database | PostgreSQL | Strong relationships and reporting for enrolment, classes, assignments and payments. |
| File storage | Private S3-compatible object storage | Secure assignment/project files using short-lived links. |
| Background jobs | Queue/worker for email, reports, file processing and retries | Prevents slow external services from blocking user actions. |
| Authentication | Session-based or standards-based identity with RBAC; staff 2FA | Secure role-aware access; do not invent custom cryptography. |
| Payments | Paystack or approved Nigerian gateway; bank transfer verification fallback | Online collection, webhooks, receipts and reconciliation. |
| Classes | Google Meet/Zoom links in Phase 1 | Avoid native video cost and moderation risk. |
| Monitoring | Central error tracking, uptime checks and structured logs | Detect failures before users report them. |

### 10.3 Core data entities

| Entity | Critical relationships / fields |
|---|---|
| User | Identity, status, role assignments, last login; never store plaintext passwords. |
| Guardian & Child | Guardian-user link; multiple children; child profile; consent; emergency details where necessary. |
| Organisation | TLab, branch/location, and Phase 1 school record; future tenant boundary. |
| Pathway / Programme / Module | Age eligibility, outcomes, curriculum order, commercial visibility. |
| Cohort / Session | Programme, organisation/location, facilitator, capacity, dates, recurrence and meeting link. |
| Enrolment | Child, cohort, status, payment plan, placement, start/end and source. |
| Lesson / Resource | Module/session mapping, facilitator guide, student-safe resource and visibility. |
| Assignment / Rubric | Cohort, instructions, dates, submission modes, criteria and publication status. |
| Submission / Grade | Learner, version, file/link, timestamp, status, feedback, marker and publication time. |
| Attendance | Session, learner, state, recorder, timestamp and edit reason. |
| Payment / Invoice | Payer, enrolment/order, amount, currency, gateway reference, status, receipt and reconciliation. |
| Progress / Certificate | Competencies, completion evidence, award rule, unique verification code. |
| Consent / Audit Event | Policy version, choice, timestamp; actor/action/target/before/after for privileged changes. |

### 10.4 Required backend modules

- Identity and access
- Families and child profiles
- Organisations and locations
- Curriculum/catalogue
- Cohorts and scheduling
- Enrolment and placement
- Classes and attendance
- Assignments/submissions/marking
- Files and media
- Payments/invoicing/reconciliation
- Progress/reports/certificates
- Notifications
- Content management
- Analytics and exports
- Audit and system settings

### 10.5 API and validation rules

- Every protected endpoint enforces permissions on the server; hiding a button is not security.
- All mutations validate ownership, role scope, state transition and input type.
- Payment webhooks verify gateway signature and are idempotent; repeated callbacks must not duplicate payment or enrolment.
- Meeting links, private files and child records are never returned to unauthorised users.
- Use stable unique IDs; never expose sequential database IDs where enumeration increases risk.
- Store timestamps in UTC and render in the cohort/user timezone.
- Use soft archive for academic and financial records; destructive deletion requires an approved retention workflow.
- Admin bulk actions require preview, confirmation, error report and audit entry.

### 10.6 Integrations

| Integration | Phase 1 behaviour | Failure handling |
|---|---|---|
| Payment gateway | Checkout, webhook verification, receipt and refund reference | Show pending safely; retry webhook processing; admin reconciliation queue. |
| Email | Activation, password reset, enrolment, class and assignment notifications | Queued delivery, retry, bounce/error log. |
| WhatsApp/SMS | Optional reminders and urgent schedule changes with consent | Fallback to email/in-app; never expose group member numbers. |
| Calendar | Download/add event to external calendar | Regenerate when class is rescheduled. |
| Meet/Zoom | Store authorised join URL; optionally generate via provider later | If unavailable, admin posts replacement and system alerts cohort. |
| Analytics | Consent-aware public funnel and internal operational events | Exclude sensitive child content and unnecessary identifiers. |

---

## 11. Security, privacy and child safeguarding

This section defines product controls, not a legal certification. TLab should obtain Nigerian privacy/legal review before launch and remove unverified "fully compliant" claims.

### 11.1 Minimum controls

- Guardian-controlled child account creation and recovery; no uncontrolled public sign-up for young children.
- Least-privilege role access and cohort scoping.
- Mandatory two-factor authentication for Super Admin and staff administrators; recommended for facilitators.
- Encryption in transit and at rest using managed services.
- Private files, time-limited access links and download auditing for sensitive exports.
- Versioned consent for terms, privacy, photography/video, communications and programme-specific needs.
- No public display of a child's surname, contact, school, precise location or unapproved image.
- No public leaderboard comparing children.
- Moderated support routes; no unrestricted adult–child direct messaging.
- Backups, restore tests, incident response owner and breach escalation procedure.
- Documented retention schedule for enquiries, academic records, payments, assignments, media and audit logs.
- Data export/correction/deletion request workflow subject to legal and safeguarding retention requirements.

### 11.2 Sensitive operational design

| Risk | Required product control |
|---|---|
| Facilitator sees unrelated children | Cohort-scoped queries and tests; default-deny access. |
| Parent sees another family's data | Guardian-child link checked on every request. |
| Public project reveals identity | Approval workflow, alias option, consent check and metadata stripping. |
| Assignment file contains malware | Type validation, scanning, private storage and safe preview. |
| Shared virtual-class link spreads | Release near class time, require authenticated learner access where provider permits, rotate compromised link. |
| Admin changes records silently | Immutable audit event with reason for sensitive corrections. |
| Former facilitator retains access | Staff offboarding disables account and sessions immediately; reassignment checklist. |

---

## 12. Notifications, reporting and analytics

### 12.1 Transactional notification matrix

| Event | Student | Parent | Facilitator | Admin |
|---|---|---|---|---|
| Account/enrolment activated | In-app/email where appropriate | Email + in-app | No | Queue visibility |
| Class reminder/change | In-app/email | Email/optional WhatsApp | Email/in-app | Failure visibility |
| Assignment published/due | In-app/email | Digest or urgent reminder | Confirmation | No |
| Submission received | Receipt | Optional digest | Queue updated | No |
| Revision/result published | In-app/email | In-app/email | Confirmation | No |
| Payment success/failure/due | No | Email/in-app | No | Finance queue |
| Repeated absence rule | Appropriate message | Email/in-app | Alert | Operational queue |

### 12.2 Reports

- **Learner progress report:** attendance, completed modules, assignments/projects, strengths, improvement focus, facilitator comment and next level.
- **Cohort report:** roster, attendance rate, curriculum completion, submission/marking status and facilitator notes.
- **Commercial report:** enrolment source, trials, conversions, collections, outstanding payments, refunds and renewals.
- **Facilitator delivery report:** sessions assigned/completed, attendance completion, marking turnaround and reports due. Use for support and quality, not simplistic punishment.
- **School term report in Phase 1:** generated by TLab admin from school cohorts; downloadable PDF/CSV and not yet a self-service school dashboard.

### 12.3 Event tracking

Track only events tied to decisions: programme viewed, CTA clicked, form started/completed, payment initiated/succeeded/failed, account activated, learner joined class, attendance recorded, assignment published/submitted/marked, report opened, renewal started/completed. Keep public marketing analytics separate from sensitive learning data.

---

## 13. UX and design system

### 13.1 Experience rules

- One primary action per page or state.
- Use plain language: "Submit assignment," not "Deploy mission payload."
- Show current status and next action at all times.
- Design mobile-first for parents and students, desktop-efficient for administrators and facilitators.
- Do not use dashboards as decoration. Every card must answer a question or lead to an action.
- Use age-appropriate visuals without making teen screens childish.
- Empty states explain what will appear and what the user should do.
- Errors preserve entered data and explain recovery.
- Critical confirmation messages include what happened, what happens next, and where to get help.

### 13.2 Design system deliverables

- Approved logo variants, colour tokens, type scale, spacing scale, icons and photography rules.
- Reusable components: header, footer, cards, tabs, forms, tables, status chips, alerts, modal, upload, rubric, calendar and empty states.
- Responsive breakpoints and tested layouts for 360px mobile, tablet, laptop and large desktop.
- All component states: default, hover, focus, disabled, loading, empty, error and success.
- Role-based dashboard wireframes before high-fidelity design.
- Clickable prototype for enrolment, run class, submit assignment and mark assignment before frontend build.

### 13.3 Content tone

TLab should sound clear, practical, intelligent, safe and optimistic. Remove cyberpunk language, inflated claims and vague outcomes. Prefer "Build a working Scratch game using loops and variables" over "Bend technology to your will."

---

## 14. Delivery plan and acceptance criteria

### 14.1 Recommended build sequence

| Sprint / stage | Outcome | Dependencies |
|---|---|---|
| 0. Discovery and cleanup | Confirm business rules, content inventory, roles, data migration, stack audit and analytics baseline. | Owner decisions and access to current code/data. |
| 1. Foundations | Design system, authentication, roles, core schema, audit foundation, CMS models. | Approved wireframes and permission matrix. |
| 2. Public website | New information architecture, pages, programme/cohort display, enquiry/trial/enrolment forms. | Approved copy, imagery and programme records. |
| 3. Operations core | Families, learners, programmes, cohorts, sessions, enrolments, admin and payments. | Payment gateway and operational rules. |
| 4. Learning delivery | Student/parent/facilitator dashboards, class page, attendance, resources. | Curriculum and scheduling data. |
| 5. Assignments and progress | Two submission modes, marking, feedback, projects, reports, certificates. | Rubrics and report template. |
| 6. QA and migration | Security/permission tests, accessibility, performance, data migration, training and pilot. | Representative pilot users and support process. |
| 7. Controlled launch | Small live cohort, monitoring, defect correction, then wider rollout. | Go-live checklist passed. |

### 14.2 Phase 1 definition of done

- A visitor can identify an appropriate programme and submit a trial/enrolment request.
- An authorised staff member can turn an approved request/payment into an active cohort enrolment without database intervention.
- A parent can activate an account, see linked children, schedule, payment status, attendance and published progress.
- A student can join/view a class, access resources and submit by file or project link.
- A facilitator can run an assigned class, take attendance, publish an assignment, mark work and publish feedback.
- A Super Admin can search and oversee every record, correct mistakes with reasons, manage roles and inspect audit history.
- Unauthorised access tests prove each role cannot view or mutate records outside its scope.
- Payment callbacks are idempotent and failed/pending payments are recoverable.
- Critical workflows pass on mobile and desktop; keyboard and screen-reader basics are tested.
- Backups, monitoring, support ownership, staff training and rollback plan exist before public launch.

### 14.3 Core end-to-end QA scenarios

| ID | Scenario | Pass condition |
|---|---|---|
| E2E-01 | New parent enrols one child and pays | One family/child/enrolment/payment; correct receipt and dashboard. |
| E2E-02 | Existing parent enrols a second child | Same guardian account; no duplicate parent; child data isolated. |
| E2E-03 | Facilitator tries unassigned cohort URL | Access denied and event logged where appropriate. |
| E2E-04 | Student uploads permitted and prohibited files | Permitted succeeds; prohibited fails clearly; no public URL. |
| E2E-05 | Student submits project link late | Submission stored, receipt issued and Late status visible. |
| E2E-06 | Facilitator returns revision, learner resubmits | Version history intact; new deadline/status correct. |
| E2E-07 | Admin edits attendance after 24 hours | Reason required; old/new values remain in audit log. |
| E2E-08 | Gateway repeats successful webhook | Only one successful payment/enrolment effect. |
| E2E-09 | Virtual class is rescheduled | Calendar, dashboard and authorised notifications update. |
| E2E-10 | Super Admin suspends staff user | All sessions revoked; access stops immediately. |

---

## 15. Phase 2–4 product roadmap

### 15.1 Phase gates

| Phase | Build only when | Product added |
|---|---|---|
| Phase 1: TLab Core | Approved now | Website plus TLab-operated learning and operations portal. |
| Phase 2: School Operations | 3–5 active school partners and one full term of observed workflows | School Admin role, school dashboard, classes, rosters, reports, CBT foundation. |
| Phase 3: Licensed Delivery | Curriculum has been delivered repeatedly; school teachers can succeed after training | Teacher portal, curriculum licensing, kits, subscriptions, school billing, basic branding. |
| Phase 4: Scaled Platform | Repeatable sales/onboarding/support and proven unit economics | Multi-tenant product, white-label domains/themes, integrations and enterprise controls. |

### 15.2 Phase 2: school portal and CBT

- School organisation with one or more campuses.
- School Admin manages authorised school staff, classes and rosters within the school only.
- TLab assigns curriculum/programmes, licences, teacher training and support entitlement.
- Principal dashboard: enrolment, attendance, curriculum completion, projects, assessments and term report.
- Teacher dashboard: lesson plan, resources, attendance, assignment/assessment delivery and learner progress.
- CBT question bank: multiple choice, multiple select, true/false, short answer and optional media.
- Assessment controls: schedule window, duration, attempts, shuffle, pass mark, accommodations and manual review where needed.
- Auto-mark objective items; manual mark written/project items.
- CBT integrity controls proportional to children and context; avoid invasive surveillance.
- School billing/licence record and renewal dates.

### 15.3 Phase 3: supported school product

- School teacher delivers TLab curriculum after certification.
- Per-student/per-term or annual licence plans.
- Curriculum release by term, age/grade and module.
- Kit inventory and replenishment.
- Implementation checklist, teacher onboarding and support tickets.
- Template school reports and Innovation Day toolkit.
- School-level theme controls: logo, approved colours and report branding. Keep "Powered by TLab/Edfrica" unless contract states otherwise.

### 15.4 Phase 4: white-label and scale

- Hard tenant isolation verified through automated tests and security review.
- Custom domain and branded emails.
- Per-tenant policies, terms and data-processing configuration.
- SSO and directory integrations for larger schools.
- Versioned curriculum licensing and entitlements.
- Usage-based or seat-based invoicing and partner analytics.
- API/webhooks for school management systems where a paying customer requires them.
- Formal uptime/support tiers, incident communication and data export/exit process.

**Critical architecture note:** Phase 1 data should include `organisation_id` / `school_id` where relevant and enforce scoped access through one authorisation layer. That makes later tenancy possible. It does not mean the team should build configurable white-label screens now.

---

## 16. Migration, content and launch checklist

### 16.1 Owner decisions required before development

- Final age range and pathway names.
- Final programme calendar, duration, cohort size, pricing, registration fees, instalment/refund rules and trial policy.
- Hub location(s), operating hours and contact routes.
- Payment gateway account and bank-transfer verification process.
- Whether students receive separate credentials and minimum age/guardian rules.
- Approved facilitator list and background/safeguarding process.
- Photography/video and online-class recording policy.
- Assignment file limits and grading/rubric policy.
- Report frequency and certificate criteria.
- Verified impact numbers, project evidence, testimonials and school logos with permissions.
- Support owner, response hours and escalation process.

### 16.2 Data migration

1. Export current users, child profiles, programmes, enrolments, payments, progress, XP/badges and content.
2. Map old fields/statuses to the new canonical model; document items that will be archived rather than migrated.
3. Deduplicate guardians and learners using controlled matching and manual review.
4. Clean false/inconsistent programme, age, pricing and schedule records.
5. Run a dry migration into staging and reconcile counts.
6. Ask pilot users to verify family links, enrolment and payment history.
7. Freeze old writes, perform final migration, reconcile, and keep a rollback snapshot.

### 16.3 Launch gates

- Content approved and no placeholder claims remain.
- All pricing calculations and discount rules verified by Finance.
- Role/permission and child-data tests passed.
- Payment live-mode test and reconciliation passed.
- Email domain authentication and delivery tested.
- Class links cannot be viewed by unauthorised users.
- File upload limits, malware/type checks and private downloads tested.
- Mobile performance and accessibility issues at agreed severity resolved.
- Backups restored successfully in a test.
- Admins/facilitators trained using a real pilot cohort.
- Support and incident contacts published internally.
- Analytics dashboard and daily launch monitoring active.

---

## Appendix A: Critical workflows

- **A1. Parent acquisition to renewal:** Website → programme/pathway → trial or enrolment → guardian account → child profile and consent → payment/approval → placement → active cohort → class/attendance → assignment/project → feedback/report → renewal or next level.
- **A2. Facilitator weekly loop:** Dashboard → open scheduled session → lesson/resources → attendance → session note/evidence → assignment → marking queue → feedback/results → learner attention flags → next session.
- **A3. School Phase 1 loop:** School enquiry → internal assessment → proposal/agreement → admin creates school organisation and cohorts → imports/creates learners with lawful basis and consent process → facilitator delivery → attendance/projects → admin-generated term report → showcase → renewal.

## Appendix B: Essential screen inventory

| Surface | Screens |
|---|---|
| Public | Home; programme/pathway listing and detail; schools; projects; about; pricing; FAQ; contact; trial; enrolment; legal; login. |
| Parent | Overview; child profile; schedule; attendance; assignments/results; progress/reports; projects; payments/receipts; certificates; consents; support. |
| Student | Overview; class page; calendar; learning/module; resources; assignments; submission; feedback; projects; certificates; profile. |
| Facilitator | Overview; schedule; cohorts; roster; run class; attendance; lesson; assignment builder; marking queue; learner progress; reports due. |
| Admin | Operations dashboard; users/families; programmes/modules; cohorts/sessions; enrolments; payments; assignments; reports; content; notifications; exports; support. |
| Super Admin | All Admin screens plus roles/permissions, settings, audit, system health, integration logs and controlled impersonation. |

## Appendix C: Prioritised backlog

| Priority | Meaning | Examples |
|---|---|---|
| P0 | Required for safe launch | Auth/RBAC, programmes/cohorts, enrolment, payment status, dashboards, class access, attendance, two submission modes, marking, audit. |
| P1 | Required soon after pilot | Progress reports, certificates, better notification preferences, project showcase approval, operational analytics. |
| P2 | Useful after usage proves need | Badges, group assignments, richer portfolio, calendar sync API, automated meeting creation. |
| Not Phase 1 | Deferred intentionally | Native video, CBT, school self-service, white-label, marketplace, mobile apps, AI marking. |

## Appendix D: Developer decision log template

| Date | Decision | Reason | Owner | Affected requirements |
|---|---|---|---|---|
| | | | | |

## Appendix E: Recommended handoff artefacts

- Approved sitemap and content model.
- Low-fidelity role dashboards and four clickable critical workflows.
- Component library and responsive design specification.
- Database entity-relationship diagram and permission policy.
- API contract and webhook/idempotency notes.
- Test plan with the E2E scenarios in this PRD.
- Migration mapping and reconciliation report.
- Admin/facilitator operating guide.
- Deployment, backup, monitoring and rollback runbook.

## Appendix F: Sources and validation notes

Current website snapshot (reviewed 8 September 2026):

- TLab home: https://tlab.edfrica.org/
- TLab membership/pricing: https://tlab.edfrica.org/membership
- TLab login: https://tlab.edfrica.org/login

The website snapshot supports the diagnosis of club/course complexity, age and positioning inconsistencies, pricing contradictions, gamification-led messaging and unverified compliance/superlative claims. Prices and programme details in this PRD are intentionally not finalised; the product owner must approve canonical values before build.

**Legal/privacy note:** this document specifies practical product controls but is not legal advice or a compliance certification. TLab should have its privacy notice, child-data basis, consent design, retention schedule, processor agreements and incident process reviewed for Nigerian requirements before launch.

---

## Product owner sign-off

| Approval item | Owner | Status / date |
|---|---|---|
| Phase 1 scope and exclusions | | |
| Roles and permissions | | |
| Programme/pricing rules | | |
| Assignment and marking workflow | | |
| Privacy/safeguarding decisions | | |
| Launch acceptance criteria | | |