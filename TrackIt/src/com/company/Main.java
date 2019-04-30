package com.company;
import java.sql.*;
public class Main {
  static Connection db;
  public static void main(String[] args){
    try{
      connectDB();
    }catch (SQLException exp){
      System.out.println("Database connection error.");
      exp.printStackTrace();
      return;
    }
    try {
      createTables();
    }catch (SQLException exp){
      System.out.println("Cannot create tables.");
      exp.printStackTrace();
      return;
    }

  }
  private static void connectDB() throws SQLException {
    db = DriverManager.getConnection("jdbc:mysql://139.179.11.31/gorkem_erturk","gorkem.erturk","41Gp3cPk");
  }
  private static void createTables() throws SQLException {
    Statement stmt = db.createStatement();
    //drop one by one
    //or put some checks to save table dependencies and drop in one statement

    stmt.executeUpdate("drop table IF EXISTS AttachedCard;");
    stmt.executeUpdate("drop table IF EXISTS AssignsIssue;");
      stmt.executeUpdate("drop table IF EXISTS AttachedIssue;");
    stmt.executeUpdate("drop table IF EXISTS Mention;");
    stmt.executeUpdate("drop table IF EXISTS Comment;");
    stmt.executeUpdate("drop table IF EXISTS Retains;");
    stmt.executeUpdate("drop table IF EXISTS AssignsCard;");
    stmt.executeUpdate("drop table IF EXISTS Watchlist;");
    stmt.executeUpdate("drop table IF EXISTS Archive;");
    stmt.executeUpdate("drop table IF EXISTS Actions;");
    stmt.executeUpdate("drop table IF EXISTS MemberOf;");
    stmt.executeUpdate("drop table IF EXISTS Attachment;");
    stmt.executeUpdate("drop table IF EXISTS Issue;");
    stmt.executeUpdate("drop table IF EXISTS Releases;");
    stmt.executeUpdate("drop table IF EXISTS Cards;");
    stmt.executeUpdate("drop table IF EXISTS Lists;");
    stmt.executeUpdate("drop table IF EXISTS CardTag;");
    stmt.executeUpdate("drop table IF EXISTS IssueTag;");
    stmt.executeUpdate("drop table IF EXISTS Event;");
    stmt.executeUpdate("drop table IF EXISTS Schedule;");
    stmt.executeUpdate("drop table IF EXISTS Contributes;");
    stmt.executeUpdate("drop table IF EXISTS Board;");
    stmt.executeUpdate("drop table IF EXISTS Team;");
    stmt.executeUpdate("drop table IF EXISTS Chooses;");
    stmt.executeUpdate("drop table IF EXISTS Theme;");
    stmt.executeUpdate("drop table IF EXISTS Project;");
    stmt.executeUpdate("drop table IF EXISTS PrivilegedUser;");
    stmt.executeUpdate("drop table IF EXISTS StandardUser;");
    stmt.executeUpdate("drop table IF EXISTS User;");

    //-----------------CREATE TABLE strings (SQL stmts)--------------------
    String releases = "CREATE TABLE Releases(" +
    "release_id INTEGER PRIMARY KEY AUTO_INCREMENT," +
    "name VARCHAR(50) NOT NULL," +
    "start_date DATE NOT NULL," +
    "end_date DATE," +
    "version VARCHAR(20)," +
    "URL VARCHAR(200)," +
    "note VARCHAR(200)," +
    "user_id INTEGER NOT NULL," +
    "project_id INTEGER NOT NULL," +
    "FOREIGN KEY (user_id) REFERENCES User(user_id)," +
    "FOREIGN KEY (project_id) REFERENCES Project(project_id)," +
    "CHECK (start_date <= end_date)) " +
    "ENGINE=INNODB;";

    String attachment = "CREATE TABLE Attachment(" +
    "attachment_id INTEGER PRIMARY KEY AUTO_INCREMENT," +
    "name VARCHAR(50) NOT NULL,"+
    "URL VARCHAR (200),"+
    "type VARCHAR (20),"+
    "note VARCHAR (200),"+
    "release_id INTEGER,"+
    "project_id INTEGER,"+
    "issue_id INTEGER,"+
    "card_id INTEGER,"+
    "user_id INTEGER,"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id),"+
    "FOREIGN KEY (project_id) REFERENCES Project(project_id),"+
    "FOREIGN KEY (release_id) REFERENCES Releases(release_id),"+
    "FOREIGN KEY (issue_id) REFERENCES Issue(issue_id),"+
    "FOREIGN KEY (card_id) REFERENCES Cards(card_id))" +
    "ENGINE=INNODB;";

    String cards = "CREATE TABLE Cards(" +
    "card_id INTEGER PRIMARY KEY AUTO_INCREMENT,"+
    "title VARCHAR(50) NOT NULL,"+
    "description VARCHAR(200),"+
    "priority INTEGER,"+
    "status VARCHAR(50) NOT NULL,"+
    "note VARCHAR(200),"+
    "start_date DATE NOT NULL,"+
    "end_date DATE,"+
    "user_id INTEGER,"+
    "list_id INTEGER,"+
    "FOREIGN KEY(user_id) REFERENCES User(user_id),"+
    "FOREIGN KEY(list_id) REFERENCES Lists(list_id),"+
    "CHECK (start_date <= end_date),"+
    "CHECK (priority >= 0))"+
    "ENGINE=INNODB;";

    String lists = "CREATE TABLE Lists(" +
    "list_id INTEGER PRIMARY KEY AUTO_INCREMENT,"+
    "title VARCHAR(50) NOT NULL,"+
    "board_id INTEGER,"+
    "FOREIGN KEY (board_id) REFERENCES Board(board_id))" +
    "ENGINE=INNODB;";

    String cardTag = "CREATE TABLE CardTag(" +
    "color VARCHAR(50) NOT NULL,"+
    "name VARCHAR(50) NOT NULL,"+
    "cardtag_id INTEGER PRIMARY KEY AUTO_INCREMENT)" +
    "ENGINE=INNODB;";

    String issueTag = "CREATE TABLE IssueTag(" +
    "color VARCHAR(50) NOT NULL,"+
    "name VARCHAR(50) NOT NULL,"+
    "issuetag_id INTEGER PRIMARY KEY AUTO_INCREMENT)" +
    "ENGINE=INNODB;";

    String schedule = "CREATE TABLE Schedule("+
    "name VARCHAR(50) NOT NULL,"+
    "reminder DATE NOT NULL,"+
    "user_id INTEGER,"+
    "PRIMARY KEY (user_id),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id))"+
    "ENGINE=INNODB;";

    String event = "CREATE TABLE Event("+
    "name VARCHAR(50) NOT NULL,"+
    "date DATE NOT NULL,"+
    "user_id INTEGER,"+
    "schedule_name VARCHAR(50),"+
    "PRIMARY KEY (user_id,name, schedule_name),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id),"+
    "FOREIGN KEY (schedule_name) REFERENCES Schedule(name))"+
    "ENGINE=INNODB;";

    String team = "CREATE TABLE Team("+
    "team_id INTEGER PRIMARY KEY AUTO_INCREMENT,"+
    "name VARCHAR(50) NOT NULL,"+
    "description VARCHAR(200) NOT NULL,"+
    "formation_date DATE NOT NULL)"+
    "ENGINE=INNODB;";

    String theme = "CREATE TABLE Theme("+
    "name VARCHAR(100)," +
    "theme_id INTEGER PRIMARY KEY AUTO_INCREMENT,"+
    "color_palette VARCHAR(50) NOT NULL,"+
    "background VARCHAR(50) NOT NULL)"+
    "ENGINE=INNODB;";

    String project = "CREATE TABLE Project("+
    "project_id INTEGER PRIMARY KEY AUTO_INCREMENT,"+
    "status VARCHAR(50) NOT NULL,"+
    "name VARCHAR(50) NOT NULL,"+
    "start_date DATE NOT NULL,"+
    "end_date DATE NOT NULL,"+
    "description VARCHAR(200),"+
    "user_id INTEGER,"+
    "CHECK (end_date >= start_date),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id))"+
    "ENGINE=INNODB;";

    String actions = "CREATE TABLE Actions("+
    "item_id INTEGER PRIMARY KEY AUTO_INCREMENT,"+
    "user_id INTEGER,"+
    "project_id INTEGER,"+
    "issue_id INTEGER,"+
    "card_id INTEGER,"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id),"+
    "FOREIGN KEY (project_id) REFERENCES Project(project_id),"+
    "FOREIGN KEY (issue_id) REFERENCES Issue(issue_id),"+
    "FOREIGN KEY (card_id) REFERENCES Cards(card_id))"+
    "ENGINE=INNODB;";

    String watchlist = "CREATE TABLE Watchlist("+
    "notification_freq INTEGER,"+
    "last_updated DATE,"+
    "item_id INTEGER,"+
    "PRIMARY KEY (item_id),"+
    "FOREIGN KEY (item_id) REFERENCES Actions(item_id))"+
    "ENGINE=INNODB;";

    String archive = "CREATE TABLE Archive("+
    "archived_date DATE NOT NULL,"+
    "item_id INTEGER,"+
    "PRIMARY KEY (item_id),"+
    "FOREIGN KEY (item_id) REFERENCES Actions(item_id))"+
    "ENGINE=INNODB;";

    String board = "CREATE TABLE Board("+
    "board_id INTEGER PRIMARY KEY AUTO_INCREMENT,"+
    "name VARCHAR(50) NOT NULL,"+
    "description VARCHAR(200) NOT NULL,"+
    "create_date DATE NOT NULL,"+
    "isPublic BOOLEAN default 0,"+
    "team_id INTEGER," +
    "user_id INTEGER,"+
    "FOREIGN KEY (team_id) REFERENCES Team(team_id),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id))"+
    "ENGINE=INNODB;";

    String assignsCards = "CREATE TABLE AssignsCard("+
    "card_id INTEGER,"+
    "user_id INTEGER,"+
    "PRIMARY KEY (card_id, user_id),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id),"+
    "FOREIGN KEY (card_id) REFERENCES Cards(card_id))"+
    "ENGINE=INNODB;";


    String assignsIssue = "CREATE TABLE AssignsIssue("+
    "issue_id INTEGER,"+
    "user_id INTEGER,"+
    "PRIMARY KEY (issue_id, user_id),"+
    "FOREIGN KEY (issue_id) REFERENCES Issue(issue_id),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id))"+
    "ENGINE=INNODB;";


    String memberOf = "CREATE TABLE MemberOf("+
    "role VARCHAR(50),"+
    "user_id INTEGER,"+
    "project_id INTEGER,"+
    "PRIMARY KEY (user_id, project_id),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id),"+
    "FOREIGN KEY (project_id) REFERENCES Project(project_id))"+
    "ENGINE=INNODB;";


    String retains = "CREATE TABLE Retains("+
    "project_id INTEGER,"+
    "team_id INTEGER,"+
    "PRIMARY KEY (project_id, team_id),"+
    "FOREIGN KEY (project_id) REFERENCES Project(project_id),"+
    "FOREIGN KEY (team_id) REFERENCES Team(team_id))"+
    "ENGINE=INNODB;";


    String user = "CREATE TABLE User("+
    "user_id INTEGER PRIMARY KEY AUTO_INCREMENT,"+
    "name VARCHAR(50) NOT NULL,"+
    "username VARCHAR(50) NOT NULL,"+
    "password VARCHAR(50) NOT NULL,"+
    "email VARCHAR(50) NOT NULL)"+
    "ENGINE=INNODB;";


    String privilegedUser = "CREATE TABLE PrivilegedUser("+
    "user_id INTEGER,"+
    "PRIMARY KEY (user_id),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id))"+
    "ENGINE=INNODB;";


    String standardUser = "CREATE TABLE StandardUser("+
    "user_id INTEGER,"+
    "PRIMARY KEY (user_id),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id))"+
    "ENGINE=INNODB;";


    String issue = "CREATE TABLE Issue("+
    "issue_id INTEGER PRIMARY KEY AUTO_INCREMENT,"+
    "name VARCHAR(50) NOT NULL,"+
    "status VARCHAR(50) NOT NULL,"+
    "start_date DATE NOT NULL,"+
    "end_date DATE,"+
    "priority INTEGER,"+
    "note VARCHAR(250),"+
    "project_id INTEGER," +
    "user_id INTEGER," +
    "FOREIGN KEY (project_id) REFERENCES Project(project_id)," +
    "FOREIGN KEY (user_id) REFERENCES User(user_id),"+
    "CHECK (priority >= 0))"+
    "ENGINE=INNODB;";

    String contributes = "CREATE TABLE Contributes("+
    "user_id INTEGER,"+
    "team_id INTEGER,"+
    "role VARCHAR(50),"+
    "PRIMARY KEY (user_id, team_id),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id),"+
    "FOREIGN KEY (team_id) REFERENCES Team(team_id))"+
    "ENGINE=INNODB;";

    String comment = "CREATE TABLE Comment("+
    "item_id INTEGER, "+
    "comment VARCHAR(250),"+
    "PRIMARY KEY (item_id),"+
    "FOREIGN KEY (item_id) REFERENCES Actions(item_id))"+
    "ENGINE=INNODB;";

    String mention = "CREATE TABLE Mention("+
    "item_id INTEGER,"+
    "user_id INTEGER,"+
    "PRIMARY KEY (item_id, user_id),"+
    "FOREIGN KEY (item_id) REFERENCES Comment(item_id),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id))"+
    "ENGINE=INNODB;";

    String attachedIssue = "CREATE TABLE AttachedIssue("+
    "issuetag_id INTEGER,"+
    "issue_id INTEGER,"+
    "PRIMARY KEY (issuetag_id, issue_id)," +
    "FOREIGN KEY (issuetag_id) REFERENCES IssueTag(issuetag_id),"+
    "FOREIGN KEY (issue_id) REFERENCES Issue(issue_id) )"+
    "ENGINE=INNODB;";

    String attachedCard = "CREATE TABLE AttachedCard("+
    "card_id INTEGER," +
    "cardtag_id INTEGER,"+
    "PRIMARY KEY (cardtag_id, card_id),"+
    "FOREIGN KEY (card_id) REFERENCES Cards(card_id),"+
    "FOREIGN KEY (cardtag_id) REFERENCES CardTag(cardtag_id))"+
    "ENGINE=INNODB;";

    String chooses = "CREATE TABLE Chooses("+
    "theme_id INTEGER,"+
    "user_id INTEGER,"+
    "PRIMARY KEY (theme_id, user_id),"+
    "FOREIGN KEY (theme_id) REFERENCES Theme(theme_id),"+
    "FOREIGN KEY (user_id) REFERENCES User(user_id))"+
    "ENGINE=INNODB;";



    //execute Here
    //drop tables
    //stmt.executeUpdate(droptable);
    //create tables
    stmt.executeUpdate(theme);
    stmt.executeUpdate(team);
    stmt.executeUpdate(cardTag );
    stmt.executeUpdate(issueTag );
    stmt.executeUpdate(user );
    stmt.executeUpdate(privilegedUser );
    stmt.executeUpdate(standardUser );
    stmt.executeUpdate(contributes );
    stmt.executeUpdate(chooses );
    stmt.executeUpdate(schedule );
    //stmt.executeUpdate(event ); This cannot created it will created while using app
    stmt.executeUpdate(project );
    stmt.executeUpdate(releases);
    stmt.executeUpdate(board );
    stmt.executeUpdate(lists );
    stmt.executeUpdate(cards );
    stmt.executeUpdate(issue );
    stmt.executeUpdate(attachedCard );
    stmt.executeUpdate(assignsIssue );
    stmt.executeUpdate(memberOf );
    stmt.executeUpdate(actions );
    stmt.executeUpdate(watchlist );
    stmt.executeUpdate(archive );
    stmt.executeUpdate(assignsCards );
    stmt.executeUpdate(retains );
    stmt.executeUpdate(comment );
    stmt.executeUpdate(mention );
    stmt.executeUpdate(attachedIssue );
    stmt.executeUpdate(attachment);




















  }
}
