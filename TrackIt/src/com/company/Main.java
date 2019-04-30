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
        String droptable = "drop table IF EXISTS Releases;";


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





/*


        String accountSQL = "CREATE TABLE account " +
                "(aid CHAR(8), " +
                " branch VARCHAR(20), " +
                " balance FLOAT , " +
                " openDate DATE ," +
                " PRIMARY KEY ( aid ))" +
                "ENGINE=INNODB;";
        String ownsSQL = "CREATE TABLE owns " +
                "(cid CHAR(12), " +
                " aid CHAR(8), " +
                "PRIMARY KEY ( cid, aid )," +
                "FOREIGN KEY(cid) REFERENCES customer(cid)," +
                "FOREIGN KEY(aid) REFERENCES account(aid))" +
                "ENGINE=INNODB;";
                */
        stmt.executeUpdate(droptable);
        stmt.executeUpdate(releases);
    }
}