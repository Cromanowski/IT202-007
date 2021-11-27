# Project: 

# Project Name: (Which Project) Arcade machine
## Project Summary: (Copy from proposal) This project will create a simple Arcade with scoreboards and competitions based on the implemented game.
## Github Link: (Prod Branch of Project Folder) https://github.com/Cromanowski/IT202-007/tree/prod/public_html/Project
## Project Board Link: https://github.com/Cromanowski/IT202-007/projects/1
## Website Link: (Heroku Prod of Project folder) https://dashboard.heroku.com/apps/cmr75-prod
## Your Name: Charles Romanowski


### Line item / Feature template (use this for each bullet point)
#### Don't delete this

- [ ] (mm/dd/yyyy of completion) Feature Title (from the proposal bullet point, if it's a sub-point indent it properly)
  -  List of Evidence of Feature Completion
    - Status: Pending 
    - Direct Link: (Direct link to the file or files in heroku prod for quick testing (link to project))
    - Pull Requests
      - PR link #1 (repeat as necessary)
    - Screenshots
      - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
        - Screenshot #1 description explaining what you're trying to show


### End Line item / Feature Template

### Proposal Checklist and Evidence

- Milestone 1
- [x] 10/7 User will be able to register a new account
- [x] 10/7  User will be able to login to their account (given they enter the correct credentials)
- [x] 10/7 User will be able to logout
- [x] 11/2 Basic security rules implemented
- [x] 10/28 Basic Roles implemented
- [x] 11/2 Site should have basic styles/theme applied; everything should be styled
- [x] 10/7 Any output messages/errors should be “user friendly”
- [x] 10/14 User will be able to see their profile
- [x] 10/14 User will be able to edit their profile #24

- Milestone 2
- [X] 11/23 Pick a simple game to implement, anything that generates a score that’s more advanced than a simple random number generator (may build off of a sample from the site shared in class)  
- [X] 11/27 The system will save the user’s score at the end of the game if the user is logged in
- [] The user will be able to see their last 10 scores
- [ ] Create functions that output the following scoreboards (this will be used later)

- Milestone 3
- [ ] Users will have points associated with their account.
- [ ] Create a PointsHistory table (id, user_id, point_change, reason, created)
- [ ] Competitions table should have the following columns (id, name, created, duration, expires (now + duration), current_reward, starting_reward, join_fee, current_participants, min_participants, paid_out (boolean), min_score, first_place_per, second_place_per, third_place_per, cost_to_create, created, modified)
- [ ] User will be able to create a competition
- [ ] Each new participant causes the Reward value to increase by at least 1 or 50% of the joining fee rounded up
- [ ] Have a page where the User can see active competitions (not expired)
- [ ] Will need an association table CompetitionParticipants (id, comp_id, user_id, created)
- [ ] User can join active competitions 
- [ ] Create function that calculates competition winners

- Milestone 4
### Intructions
#### Don't delete this
1. Pick one project type
2. Create a proposal.md file in the root of your project directory of your GitHub repository
3. Copy the contents of the Google Doc into this readme file
4. Convert the list items to markdown checkboxes (apply any other markdown for organizational purposes)
5. Create a new Project Board on GitHub
   - Choose the Automated Kanban Board Template
   - For each major line item (or sub line item if applicable) create a GitHub issue
   - The title should be the line item text
   - The first comment should be the acceptance criteria (i.e., what you need to accomplish for it to be "complete")
   - Leave these in "to do" status until you start working on them
   - Assign each issue to your Project Board (the right-side panel)
   - Assign each issue to yourself (the right-side panel)
6. As you work
  1. As you work on features, create separate branches for the code in the style of Feature-ShortDescription (using the Milestone branch as the source)
  2. Add, commit, push the related file changes to this branch
  3. Add evidence to the PR (Feat to Milestone) conversation view comments showing the feature being implemented
     - Screenshot(s) of the site view (make sure they clearly show the feature)
     - Screenshot of the database data if applicable
     - Describe each screenshot to specify exactly what's being shown
     - A code snippet screenshot or reference via GitHub markdown may be used as an alternative for evidence that can't be captured on the screen
  4. Update the checklist of the proposal.md file for each feature this is completing (ideally should be 1 branch/pull request per feature, but some cases may have multiple)
    - Basically add an x to the checkbox markdown along with a date after
      - (i.e.,   - [x] (mm/dd/yy) ....) See Template above
    - Add the pull request link as a new indented line for each line item being completed
    - Attach any related issue items on the right-side panel
  5. Merge the Feature Branch into your Milestone branch (this should close the pull request and the attached issues)
    - Merge the Milestone branch into dev, then dev into prod as needed
    - Last two steps are mostly for getting it to prod for delivery of the assignment 
  7. If the attached issues don't close wait until the next step
  8. Merge the updated dev branch into your production branch via a pull request
  9. Close any related issues that didn't auto close
    - You can edit the dropdown on the issue or drag/drop it to the proper column on the project board